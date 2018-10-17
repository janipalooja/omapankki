<?php require_once('php/check-login-state.php'); ?>
<?php define('Luottokorttitapahtumat', TRUE); ?>
<?php require_once('php/get_creditcard-transactions.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Luottokortin tapahtumat - OmaPankki</title>
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
          <h4 class="card-title" style="font-size:16px;">Luottokortin tapahtumat</h4>

          <h5 style="margin:20px 0 20px 0 !important;"><?= $result[0]['KortinNimi'] ?></h5>

            <?= (count($result) == 0) ? "<p style='color:#999;text-align:center;padding:50px 0 50px 0;'><span class='glyphicon glyphicon-search' style='font-size:20px;'></span> </br> Kortilla ei ole tapahtumia.</p>" : "" ?>

           <?php foreach($result as $row): ?>

              <div class="row" style="border-bottom:1px #F0F0F0 solid;width:99%;margin:0 auto;margin-bottom:5px;padding-bottom:5px;">
                <div class="col-sm-6" style="text-align:left;">
                <?php $newDate = date("d.m.Y", strtotime($row['Pvm'])); ?>
                <div><span style="color:#0099FF;"> <?= $newDate ?></span></div>

                <div><span style="text-transform: uppercase;">
                   <?= $row['Selite'] ?>
                </span></div>

              </div>
              <div class="col-sm-6" style="text-align:right;padding-top:10px;">
                 <p>- <?= number_format($row['Summa'], 2, ',', ' ') ?> €</p>
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
