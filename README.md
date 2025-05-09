# Kirby Auctions
Render auctions xml into txt files for [Kirby CMS](https://getkirby.com).

## Installation

Copy plugin files to your plugin's directory or install via composer with `composer require eco-remi/kirby-auctions`

If copied, install symfony dependency with composer

```
composer install
```

## Usage

You must have a export-SaleID.xml in a FTP folder

* create folder and txt files needed for kirby rendering

# Auctions Products import & rendering
Run synchronisation 
```
php site/plugins/kirby-auctions/run-sync.php
```
or on json API :
http://localhost:8080/run-sync
return :
```json
{
    "success": true,
    "message": "Synchronized successfully",
    "count": 283
}
```

# Payment Form

* Create a test **order** with Fake $_POST data
```
php site/plugins/kirby-auctions/test-validate-oder.php
```

* [POST] Front Form (@see sample in /test)

http://localhost/sp-plus-payment-form

return integrated payment form.
User wil be redirect to [POST] /paid

* **[GET]** Test Payment success

http://localhost:8080/test-paid
```json
{
  "id": "myOrderId-475882",
  "transactionUuid": "1c8356b0e24442b2acc579cf1ae4d814",
  "status": "PAID",
  "amount": 0,
  "currency": "EUR",
  "customer": null,
  "orderDetails": [],
  "createdAt": "2025-05-09 12:52:17",
  "updatedAt": "2025-05-09 12:54:54"
}
```

* **[POST]** User Redirection after paiement (auto)
  http://localhost:8080/paid

will return
```json
{
  "id": "myOrderId-475882",
  "transactionUuid": "1c8356b0e24442b2acc579cf1ae4d814",
  "status": "PAID",
  "amount": 0,
  "currency": "EUR",
  "customer": null,
  "orderDetails": [],
  "createdAt": "2025-05-09 12:52:17",
  "updatedAt": "2025-05-09 12:54:54"
}
```
 Or throw error 

* **[POST]** Bank return (auto) with payment validation data 
  http://localhost:8080/sp-plus-ipn 
```json
// INPUT $_POST data
// kr-answer is represented by DTO entity/Order::class
[
    "kr-hash": "ezfhzoirghrjrandom"
    "kr-hash-algorithm": "SHA4"
    "kr-answer-type": "ipn"
    "kr-answer": {
        "id": "demo-order",
        "transactionUuid": "6d96419e2134480bad0fac4961d4ae9b",
        "status": "RUNNING",
        ...
    }
]
```
this will mainly update Order Status

* **[GET]** Test Payment form with
  http://localhost:8080/sp-plus-payment-demo

* [POST] Front Form Posted ON http://localhost:8080/sp-plus-payment-demo
will return payment form snippet

```html
<!DOCTYPE html>
<html lang="Fr-fr">
<head>

    <!-- SP plus payment module -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script type="text/javascript"
            src="https://static.systempay.fr/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
            kr-public-key="73239078:testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ"
            kr-post-url-success="/paid"
            kr-language="fr-FR">
    </script>

    <!--  theme NEON should be loaded in the HEAD section   -->
    <link rel="stylesheet" href="https://static.systempay.fr/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script src="https://static.systempay.fr/static/js/krypton-client/V4.0/ext/classic.js">
    </script>
</head>


<body data-barba="wrapper" data-page="default">

<main class="" data-barba="container" data-barba-namespace="home">

    <div class="kr-embedded" kr-card-form-expanded kr-form-token="token">
    </div>

</main>
```
