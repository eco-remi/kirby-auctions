<?php
/**
 * get from https://github.com/lyra/rest-php-examples/blob/master/www/sample/popin.php
 *
 *
 * <!-- STEP :
 * 1 : load the JS library
 * 2 : required public key
 * 3 : the JS parameters url success and langage EN  -->
 *
 */
?>
<!DOCTYPE html>
<html lang="Fr-fr">
<head>

    <!-- SP plus payment module -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script type="text/javascript"
            src="<?php echo DOMAIN_URL; ?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
            kr-public-key="<?php echo PUBLIC_KEY; ?>"
            kr-post-url-success="/paid"
            kr-language="fr-FR">
    </script>

    <!--  theme NEON should be loaded in the HEAD section   -->
    <link rel="stylesheet" href="<?php echo DOMAIN_URL; ?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script src="<?php echo DOMAIN_URL; ?>/static/js/krypton-client/V4.0/ext/classic.js">
    </script>
</head>


<body data-barba="wrapper" data-page="default">

<main class="" data-barba="container" data-barba-namespace="home">

    <div class="kr-embedded" kr-card-form-expanded kr-form-token="<?php echo $formToken ?? ''; ?>">
    </div>

</main>
