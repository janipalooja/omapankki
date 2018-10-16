<?php define('TilitJaKortit', TRUE); ?>
<?php require_once('php/get_bank_accounts.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tilit ja Kortit - OmaPankki</title>
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
          <h4 class="card-title">Tilit</h4>

          <!-- Get Bank Accounts -->
          <?php $i = 1; foreach($result as $row): ?>
             <!-- Custom list element for bank accounts -->
            <div class="custom-list-element <?= ($i == count($result)) ? last:notLast ?>">
               <div class="col-sm-2 badge-col">
                  <span class="custom-badge"><?= $i; ?></span>
               </div>
               <div class="col-sm-6 account-info-col">
                  <h5><?= $row['TilinNimi']; ?></h5>
                  <p>Saldo: <?= number_format($row['Saldo'], 2, ',', ' '); ?> €</p>
                  <p><?= chunk_split($row['Tilinumero'], 4, ' '); ?></p>
               </div>
               <div class="col-sm-4 transactions-btn-col">
                  <a href="tilitapahtumat.php?tili=<?= $row['idTili']; ?>" role="button" class="btn btn-block">Tilipahtumat</a>
               </div>
            </div>
            <!-- Custom list element for bank accounts -->
          <?php $i++; endforeach ?>
          <!-- Get Bank Accounts -->

        </div>
      </div>

      <?php require_once('php/get_cards.php'); ?>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Kortit</h4>

          <!-- Get Bank Accounts -->
          <?php $i = 1; foreach($result as $row): ?>
             <!-- Custom list element for bank accounts -->
            <div class="custom-list-element <?= ($i == count($result)) ? last:notLast ?>">
               <div class="col-sm-2 badge-col">
                  <span class="custom-badge"><?= $i; ?></span>
               </div>
               <div class="col-sm-6 account-info-col">
                  <h5><?= $row['KortinNimi']; ?></h5>

                  <?php
                  if($row['KortinTyyppi'] == "debit"){
                     echo "<p>Liitetty tiliin: ID$row[idTili]</p>";
                  }
                  else {
                     echo "<p>Luottoraja: $row[Luottoraja] €</p>";
                  }
                  ?>

                  <p class="card-type <?= $row['KortinTyyppi'] ?>-card"><b><?= $row['KortinTyyppi']; ?></b></p>
               </div>
               <div class="col-sm-4 transactions-btn-col">
                  <div class="btn-group btn-group-justified">
                     <?php if($row['KortinTyyppi'] == "credit"): ?>
                    <a href="#" class="btn btn-primary">Tapahtumat</a>
                    <?php endif ?>
                    <a href="#" class="btn btn-settings" title="Muuta kortin asetuksia">Asetukset</a>
                  </div>
               </div>
            </div>
            <!-- Custom list element for bank accounts -->
          <?php $i++; endforeach ?>
          <!-- Get Bank Accounts -->

        </div>
      </div>
      <?php require_once('template/footer.php'); ?>
    </div>

    <?php require_once('template/right_sidebar.php'); ?>

  </div>
</div>

</body>
</html>
