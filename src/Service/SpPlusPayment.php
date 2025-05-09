<?php

namespace Auction\Service;

use Auction\Entity\Customer;
use Auction\Entity\Order;
use Auction\Entity\OrderDetail;
use DateTime;
use Kirby\Exception\Exception;

require_once __DIR__ . '/../../spplus_config.php';

class SpPlusPayment
{
    /** @see https://paiement.systempay.fr/doc/fr-FR/rest/V4.0/javascript/guide/notification/ipn.html */
    public static function instantPaymentNotification(): string
    {
        if (empty($_POST)) {
            throw new Exception('Invalid method. <br />');
        }

        // STEP 1 : check the signature with the password
        if (!self::checkHash($_POST, PASSWORD)) {
            throw new Exception('Invalid signature. <br />');
        }

        /** @var Bank-return POST date $answer
         * @see /data/post-ipn.json
         * ** /
        $answer = [
            'kr-hash' => $_POST['kr-hash'],
            'kr-hash-algorithm' => $_POST['kr-hash-algorithm'],
            'kr-answer-type' => $_POST['kr-answer-type'],
            'kr-answer' => json_decode($_POST['kr-answer'], true)
        ];
        /* **/

        $bankData = json_decode($_POST['kr-answer'] ?? [], true);

        /* STEP 2 : get some parameters from the answer */

        /* STEP 3 : save in local database (custom code) */
        $order = OrderFactory::adaptFromBankAnswer($bankData);

        /**
         * Message returned to the IPN caller
         * You can return want you want but
         * HTTP response code should be 200
         */
        return sprintf('OK! Order %s is %s',
            $order->getId(),
            $order->getStatus()
        );
    }

    public static function getPayButton(array|Order $order): string
    {
        return self::getFormToken($order);
    }

    /** @see https://paiement.systempay.fr/doc/fr-FR/rest/V4.0/javascript/guide/notification/ipn.html */
    public static function getFormToken(array|Order $order): string
    {
        // STEP 1 : the data request @see order DTO adaptation

        // STEP 3 : call the endpoint V4/Charge/CreatePayment with the json data.
        $response = self::post(SERVER . "/api-payment/V4/Charge/CreatePayment",
            json_encode(self::adaptOrderToTokenRequest($order))
        );

        // Check if there is errors.
        if ($response['status'] != 'SUCCESS') {
            // An error occurs, throw exception
            $error = $response['answer'];
            throw new Exception('error ' . $error['errorCode'] . ': ' . $error['errorMessage']);
        }

        // Everything is fine, extract the formToken
        // STEP 4 : the answer with the creation of the formToken
        return $response['answer']['formToken'];
    }


    public static function checkHash($data, $key)
    {
        $supported_sign_algos = array('sha256_hmac');
        if (!in_array($data['kr-hash-algorithm'], $supported_sign_algos)) {
            return false;
        }
        $kr_answer = str_replace('\/', '/', $data['kr-answer']);
        $hash = hash_hmac('sha256', $kr_answer, $key);
        return ($hash == $data['kr-hash']);
    }


    public static function post($url, $data)
    {
        // STEP 2 : send data with curl command
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERPWD, USERNAME . ':' . PASSWORD);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($curl, CURLOPT_TIMEOUT, 45);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $raw_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!in_array($status, array(200, 401))) {
            curl_close($curl);

            throw new \Exception("Error: call to URL $url failed with unexpected status $status, response $raw_response.");
        }

        $response = json_decode($raw_response, true);
        if (!is_array($response)) {
            $error = curl_error($curl);
            $errno = curl_errno($curl);

            curl_close($curl);

            throw new \Exception("Error: call to URL $url failed, response $raw_response, curl_error $error, curl_errno $errno.");
        }

        curl_close($curl);

        return $response;
    }

    /**
     * @return array
     */
    public static function adaptOrderToTokenRequest(Order $order): array
    {
        $cartItem = [];
        foreach ($order->getOrderDetails() as $orderDetail) {
            $cartItem[] = [
                'productLabel' => $orderDetail->getLabel(),
                'productType' => 'AUCTION_AND_GROUP_BUYING',
                'productRef' => $orderDetail->getReference(),
                'productQty' => $orderDetail->getQty(),
                'productAmount' => $orderDetail->getAmount(),
            ];
        }
        return [
            'orderId' => $order->getId(),
            'amount' => $order->getOrderTotal(),
            'contrib' => 'e-responsable',
            'currency' => $order->currency,
            'customer' => [
                'email' => $order->customer->email,
                'reference' => $order->customer->reference,
                'billingDetails' => [
                    'language' => $order->customer->language,
                    'title' => $order->customer->title,
                    'firstName' => $order->customer->firstName,
                    'lastName' => $order->customer->lastName,
                    'category' => $order->customer->category,
                    'address' => $order->customer->address,
                    'zipCode' => $order->customer->zipCode,
                    'city' => $order->customer->city,
                    'phoneNumber' => $order->customer->phoneNumber,
                    'country' => $order->customer->country
                ],
                "shoppingCart" => [
                    'cartItemInfo' => $cartItem,
                ],
            ],
            'transactionOptions' => [
                'cardOptions' => [
                    'retry' => 1,
                    "manualValidation" => "YES",
                ]
            ],
        ];
    }
}
