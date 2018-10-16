<?php define('Tilitapahtumat', TRUE); ?>
<?php require_once('php/get_transactions.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tilitapahtumat - OmaPankki</title>
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
          <h4 class="card-title" style="font-size:16px;">Tilitapahtumat</h4>

         <ul class="nav nav-tabs" style="margin-bottom:10px;">
          <li class="active"><a data-toggle="tab" href="#menot">Menot</a></li>
          <li><a data-toggle="tab" href="#tulot">Tulot</a></li>
        </ul>

      <div class="tab-content">
         <div id="menot" class="tab-pane fade in active">
            <?= (count($out) == 0) ? "<p style='color:#999;text-align:center;padding:50px 0 50px 0;'><span class='glyphicon glyphicon-search' style='font-size:20px;'></span> </br> Ei tilitapahtumia.</p>" : "" ?>

           <?php foreach($out as $row): ?>
              <div class="row" style="border-bottom:1px #F0F0F0 solid;width:99%;margin:0 auto;margin-bottom:5px;padding-bottom:5px;">
                 <a href="tapahtuman-tiedot.php?tili=<?= $_GET['tili'] ?>&tapahtuma=<?= $row['idTilitapahtuma'] ?>" style="color:#666;">
              <div class="col-sm-6" style="text-align:left;">
                <?php $newDate = date("d.m.Y", strtotime($row['TapahtumanPvm'])); ?>
                <div><span style="color:#0099FF;"> <?= $newDate ?></span></div>

                <div><span style="text-transform: uppercase;">
                   <?= $row['SaajanNimi'] ?>
                </span></div>

              </div>
              <div class="col-sm-6" style="text-align:right;padding-top:10px;">
                 <p>- <?= number_format($row['Summa'], 2, ',', ' ') ?> €</p>
              </div>
           </a>
              </div>
           <?php endforeach ?>
         </div>
         <div id="tulot" class="tab-pane fade">
            <?= (count($in) == 0) ? "<p style='color:#999;text-align:center;padding:50px 0 50px 0;'><span class='glyphicon glyphicon-search' style='font-size:20px;'></span> </br> Ei tilitapahtumia.</p>" : "" ?>

           <?php foreach($in as $row): ?>
              <div class="row" style="border-bottom:1px #F0F0F0 solid;width:99%;margin:0 auto;margin-bottom:5px;padding-bottom:5px;">
                 <a href="tapahtuman-tiedot.php?tili=<?= $_GET['tili'] ?>&tapahtuma=<?= $row['idTilitapahtuma'] ?>" style="color:#666;">
              <div class="col-sm-6" style="text-align:left;">
                 <?php $newDate = date("d.m.Y", strtotime($row['TapahtumanPvm'])); ?>
                 <div><span style="color:#0099FF;"> <?= $newDate ?></span></div>

                <div><span style="text-transform: uppercase;">
                   <?= $row['MaksajanNimi'] ?>
                </span></div>

              </div>
              <div class="col-sm-6" style="text-align:right;padding-top:10px;">
                 <p>+ <?= number_format($row['Summa'], 2, ',', ' ') ?> €</p>
              </div>
           </a>
              </div>
           <?php endforeach ?>
         </div>
      </div>

        </div>
      </div>
      <?php require_once('template/footer.php'); ?>
    </div>

    <?php require_once('template/right_sidebar.php'); ?>

  </div>
</div>

</body>
</html>
