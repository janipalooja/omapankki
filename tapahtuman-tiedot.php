<?php require_once('php/check-login-state.php'); ?>
<?php define('Tilitapahtumat', TRUE); ?>
<?php require_once('php/get_transaction_data.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tapahtuman tiedot - OmaPankki</title>
<?php require_once('template/head.php'); ?>
</head>
<body>

<?php $noMobileNavbar = FALSE; require_once('template/navbar.php'); ?>

<div class="container-fluid text-center">
  <div class="row content">

    <?php $E_invoices_page = FALSE; require_once('template/left_sidebar.php'); ?>

    <div class="col-sm-6 text-left">

      <div class="card">
        <div class="card-body">
          <h4 class="card-title" style="font-size:16px;">Tapahtuman tiedot</h4>

          <a href="#" onclick="window.history.go(-1); return false;" class="btn back-btn" role="button" style="margin:20px 0 20px 0;padding:10px;">Takaisin</a>

          <div class="row" style="margin-bottom:20px;">
             <div class="col-sm-6">
                <div><b>Maksupäivä</b></div>
                <?php $newDate = date("d.m.Y", strtotime($result[0]['TapahtumanPvm'])); ?>
                <div><span style="color:#0099FF;"> <?= $newDate ?></span></div>
             </div>
             <div class="col-sm-6" style="text-align:right;">
                <div><b>Summa</b></div>
                <div><span><?= $result[0]['Summa'] ?> €</span></div>
             </div>

          </div>
          <div class="row" style="margin-bottom:20px;">
             <div class="col-sm-6">
               <div><span style="font-weight: bold;">Maksun saaja</span></div>
               <div><span style="text-transform: uppercase;color:#666;"><?= $result[0]['SaajanNimi'] ?></span></div>
               <div><span style="text-transform: uppercase;color:#666;"><?= chunk_split($result[0]['Tilinumero'], 4, ' ') ?></span></div>
             </div>
             <div class="col-sm-6" style="text-align:right;">
                <div><span style="font-weight: bold;">Viitenumero</span></div>
               <div><span style="text-transform: uppercase;color:#666;"><?= chunk_split($result[0]['Viitenumero'], 4, ' ') ?></span></div>
             </div>
          </div>
          <div class="row" style="margin-bottom:20px;">
             <div class="col-sm-6">
               <div><span style="font-weight: bold;">Viesti</span></div>
               <div><span style="text-transform: uppercase;color:#666;"><?= $result[0]['Viesti'] ?></span></div>
             </div>
             <div class="col-sm-6" style="text-align:right;">

             </div>
          </div>


        </div>
      </div>
    </div>

    <?php require_once('template/right_sidebar.php'); ?>

  </div>
</div>

<?php require_once('template/mobile-tab-bar.php'); ?>

</body>
</html>
