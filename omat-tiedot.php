<?php require_once('php/check-login-state.php'); ?>
<?php require_once('php/get_userdata.php'); ?>
<?php define('OmatTiedot', TRUE); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Omat tiedot - OmaPankki</title>
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
          <h4 class="card-title" style="font-size:16px;">Omat tiedot</h4>
          <?php foreach($result as $row): ?>
          <div class="row" style="margin-bottom:20px;">
             <div class="col-sm-6">
                <div><b>Nimi</b></div>
                <div><span style="color:#666;"><?= $row['Etunimi'] ?> <?= $row['Sukunimi'] ?></span></div>
             </div>
             <div class="col-sm-6" style="text-align:right;">
                <div><b>Käyttäjätunnus</b></div>
                <div><span><?= $row['Kayttajatunnus'] ?></span></div>
             </div>

          </div>
          <div class="row" style="margin-bottom:20px;">
             <div class="col-sm-6">
               <div><span style="font-weight: bold;">ID-Numero</span></div>
               <div><span style="text-transform: uppercase;color:#666;"><?= $row['idAsiakas'] ?></span></div>
             </div>
             <div class="col-sm-6" style="text-align:right;">
                <div><span style="font-weight: bold;">Henkilötunnus</span></div>
               <div><span style="text-transform: uppercase;color:#666;"><?= $row['HeTu'] ?></span></div>
             </div>
          </div>
          <div class="row" style="margin-bottom:20px;">
             <div class="col-sm-6">
               <div><span style="font-weight: bold;">Sähköposti</span></div>
               <div><span style="color:#666;"><?= $row['Sahkoposti'] ?></span></div>
             </div>
             <div class="col-sm-6" style="text-align:right;">
                <div><span style="font-weight: bold;">Puhelinnumero</span></div>
               <div><span style="text-transform: uppercase;color:#666;"><?= $row['Puhelinnumero'] ?></span></div>
             </div>
          </div>
          <div class="row" style="margin-bottom:20px;">
             <div class="col-sm-6">
               <div><span style="font-weight: bold;">Osoite</span></div>
               <div><span style="color:#666;"><?= $row['Osoite'] ?></span></div>
               <div><span style="color:#666;"><?= $row['Postinumero'] ?> <?= $row['Postitoimipaikka'] ?></span></div>
             </div>
             <div class="col-sm-6" style="text-align:right;">
             </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>

    <?php require_once('template/right_sidebar.php'); ?>

  </div>
</div>

<?php require_once('template/mobile-tab-bar.php'); ?>

</body>
</html>
