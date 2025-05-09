<main class="" data-barba="container" data-barba-namespace="home">
    <?php
        if (!empty($order) && $order instanceof \Auction\Entity\Order):
    ?>
    <h2>Payement success</h2>
    <div class="container">
        <h2>Data recevied :</h2>
        <!-- STEP 2 : get some parameters from the 'kr-answer'  -->
        <strong>Commande enregistré avec succès</strong>
        <br />
        <strong>Le statut de la transaction :</strong>
        <?php echo $order->getStatus(); ?>
        <br />
        <strong>Numéro de la transaction :</strong>
        <?php echo $order->getTransactionUuid(); ?>
        <br />
        <strong>Numéro de la commande :</strong>
        <?php echo $order->getId(); ?>
        <br />
    </div>
    <?php endif; ?>

</main>
