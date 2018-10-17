<?php require_once('php/check-login-state.php'); ?>
<?php define('E_Laskut', TRUE); ?>
<?php require_once('php/get-e-invoices.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>E-Laskut - OmaPankki</title>
<?php require_once('template/head.php'); ?>
</head>
<body>

<?php $noMobileNavbar = FALSE; require_once('template/navbar.php'); ?>

<div class="container-fluid text-center">
  <div class="row content">

    <?php require_once('template/left_sidebar.php'); ?>

    <div class="col-sm-6 text-left">

      <div class="card">
        <div class="card-body">
          <h4 class="card-title" style="font-size:16px;">E-Laskut</h4>

          <ul class="nav nav-tabs" style="margin-bottom:10px;">
           <li class="active"><a data-toggle="tab" href="#avoimet">Avoimet (<?= count($unpaidE_Invoices) ?>)</a></li>
           <li><a data-toggle="tab" href="#maksetut">Maksetut (<?= count($paidE_Invoices) ?>)</a></li>
         </ul>

         <div class="tab-content">
            <div id="avoimet" class="tab-pane fade in active">

               <?= (count($unpaidE_Invoices) == 0) ? "<p style='color:#999;text-align:center;padding:50px 0 50px 0;'><span class='glyphicon glyphicon-search' style='font-size:20px;'></span> </br> Ei avoimia e-laskuja.</p>" : "" ?>

               <?php $i = 1; foreach($unpaidE_Invoices as $row): ?>
                 <div class="custom-list-element <?= ($i == count($unpaidE_Invoices)) ? 'last' : 'notLast' ?>">
                    <div class="col-sm-2 badge-col">
                       <span class="custom-badge"><?= $i; ?></span>
                    </div>
                    <div class="col-sm-6 account-info-col">
                       <h5><?= $row['LaskuttajanNimi']; ?></h5>
                       <p>Summa: <?= $row['Summa']; ?> €</p>
                       <?php $newDate = date("d.m.Y", strtotime($row['Erapaiva'])); ?>
                       <p>Eräpäivä: <?= $newDate ?></p>
                    </div>
                    <div class="col-sm-4 transactions-btn-col" style="padding:10px;">
                       <a href="uusi-maksu.php?idELasku=<?= $row['idELasku']; ?>&tilinumero=<?= $row['LaskuttajanTilinumero']; ?>&saaja=<?= $row['LaskuttajanNimi']; ?>&viitenumero=<?= $row['Viitenumero']; ?>&summa=<?= $row['Summa']; ?>&viesti=E-Lasku: <?= $row['Laskunumero']; ?>" role="button" class="btn btn-block btn-pay-e-invoice">Maksa</a>
                    </div>
                 </div>
               <?php $i++; endforeach ?>

            </div>
            <div id="maksetut" class="tab-pane fade">

               <?= (count($paidE_Invoices) == 0) ? "<p style='color:#999;text-align:center;padding:50px 0 50px 0;'><span class='glyphicon glyphicon-search' style='font-size:20px;'></span> </br> Ei maksettuja e-laskuja.</p>" : "" ?>

               <?php $i = 1; foreach($paidE_Invoices as $row): ?>
                 <div class="custom-list-element <?= ($i == count($paidE_Invoices)) ? 'last' : 'notLast' ?>">
                    <div class="col-sm-2 badge-col">
                       <span class="custom-badge"><?= $i; ?></span>
                    </div>
                    <div class="col-sm-6 account-info-col">
                       <h5><?= $row['LaskuttajanNimi']; ?></h5>
                       <p>Summa: <?= $row['Summa']; ?> €</p>
                       <?php $newDate = date("d.m.Y", strtotime($row['MaksettuPvm'])); ?>
                       <p>Maksettu: <?= $newDate ?></p>
                    </div>
                    <div class="col-sm-4" style="padding:10px;">
                       <button class="btn btn-block btn-new-payment" disabled><i class="glyphicon glyphicon-check"></i></button>
                    </div>
                 </div>
               <?php $i++; endforeach ?>

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
