<?php require_once('php/new-transaction.php'); ?>
<?php require_once('php/get_bank_accounts.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tilitapahtumat - OmaPankki</title>
<?php $newTransactionPage = TRUE; require_once('template/head.php'); ?>

<?php if(isset($newTransactionPage)): ?>
<script>
$(function() {
$('a[data-toggle="tab"]').on('click', function(e) {
     window.localStorage.setItem('activeTab', $(e.target).attr('href'));
});
var activeTab = window.localStorage.getItem('activeTab');
if (activeTab) {
     $('#myTab a[href="' + activeTab + '"]').tab('show');
}
});
</script>
<?php endif ?>

</head>
<body>

<?php $noMobileNavbar = FALSE; require_once('template/navbar.php'); ?>

<div id="new-transaction" class="container-fluid text-center">
  <div class="row content">

    <?php $E_invoices_page = FALSE; require_once('template/left_sidebar.php'); ?>

    <div class="col-sm-9 text-left">

      <div class="card">
        <div class="card-body">
          <h4 class="card-title" style="font-size:16px;">Uusi maksu</h4>

          <ul class="nav nav-tabs" id="myTab" style="margin-bottom:10px;">
           <li class="active"><a href="#uusi-maksu" data-toggle="tab">Uusi maksu</a></li>
           <li><a href="#oma-tilisiirto" data-toggle="tab">Oma tilisiirto</a></li>
         </ul>

         <?php if($transactionFailed): ?>
         <div class="alert alert-danger alert-dismissible fade in">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           <strong>Virhe!</strong> <?= $errorMessage ?>
         </div>
         <?php endif ?>

         <div class="tab-content">
           <div id="uusi-maksu" class="tab-pane fade in active">
             <div class="form-group">
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                   <input type="hidden" name="idELasku" value="<?= (isset($_GET['idELasku'])) ? $_GET['idELasku'] : '' ?><?= (isset($_SESSION['idELasku'])) ? $_SESSION['idELasku'] : '' ?>">
           <select class="form-control" style="margin-bottom:20px;">
             <option>Käytä maksupohjaa</option>
              <option disabled>Ei maksupohjia</option>
           </select>

           <select class="form-control" name="tililta" style="margin-bottom:20px;">
             <option value="">Valitse käytettävä tili</option>
             <?php foreach($result as $row): ?>
                <?php if(isset($_SESSION['tililta'])) {$kaytettavaTili =  $_SESSION['tililta'];} ?>
                <option value="<?= $row['idTili']; ?>" <?= (isset($kaytettavaTili) && $row['idTili'] == $kaytettavaTili) ? 'selected' : '' ?>>
                   <?= $row['TilinNimi']; ?> (<?= $row['Saldo']; ?>)
                </option>
                <?php endforeach ?>
           </select>

           <div class="input-group">
            <span class="input-group-addon">Saajan tilinumero</span>
            <input id="msg" type="text" class="form-control" name="saajanTilinumero" value="<?= (isset($_GET['tilinumero'])) ? $_GET['tilinumero'] : '' ?><?= (isset($_SESSION['saajanTilinumero'])) ? $_SESSION['saajanTilinumero'] : '' ?>" placeholder="Kirjoita IBAN-tilinumero">
          </div>

          <div class="input-group">
           <span class="input-group-addon">Saajan nimi</span>
           <input id="msg" type="text" class="form-control" name="saajanNimi" value="<?= (isset($_GET['saaja'])) ? $_GET['saaja'] : '' ?><?= (isset($_SESSION['saajanNimi'])) ? $_SESSION['saajanNimi'] : '' ?>" placeholder="Etunimi Sukunimi">
        </div>

        <div class="input-group">
         <span class="input-group-addon">Viitenumero</span>
         <input id="msg" type="text" class="form-control" name="viitenumero" value="<?= (isset($_GET['viitenumero'])) ? $_GET['viitenumero'] : '' ?><?= (isset($_SESSION['viitenumero'])) ? $_SESSION['viitenumero'] : '' ?>" placeholder="Käytä laskussa mainittua viitenumeroa">
       </div>

       <div class="row">
          <div class="col-sm-6">
             <div class="panel panel-default">
               <div class="panel-heading">Viesti</div>
               <div class="panel-body" style="padding:0;">
                  <div class="form-group">
                   <textarea class="form-control" rows="4" name="viesti" style="border:0;margin:0;" placeholder="Vapaamuotoinen viesti vastaanottajalle"><?= (isset($_GET['viesti'])) ? $_GET['viesti'] : '' ?><?= (isset($_SESSION['viesti'])) ? $_SESSION['viesti'] : '' ?></textarea>
                 </div>
               </div>
             </div>
          </div>
          <div class="col-sm-6">
             <div class="input-group">
               <span class="input-group-addon">Eräpäivä</span>
               <input id="msg" type="date" class="form-control" name="erapaiva" value="<?= (isset($_SESSION['erapaiva'])) ? $_SESSION['erapaiva'] : date("Y-m-d") ?>" placeholder="pp.kk.vvvv">
            </div>
            <div class="input-group">
               <span class="input-group-addon">Summa</span>
               <input id="msg" type="text" class="form-control" name="summa" value="<?= (isset($_GET['summa'])) ? $_GET['summa'] : '' ?><?= (isset($_SESSION['summa'])) ? $_SESSION['summa'] : '' ?>" placeholder="0,00">
            </div>
            <div class="row">
               <div class="col-sm-6">
                  <button type="submit" name="clear-form" class="btn btn-danger btn-block" style="padding:10px 0 10px 0;margin-bottom:20px;">Tyhjennä lomake</button>
               </div>
               <div class="col-sm-6">
                  <button type="submit" name="submit" class="btn btn-new-payment btn-block"><?= (isset($_GET['idELasku'])) ? 'Maksa E-Lasku' : 'Maksa' ?></button>
               </div>
            </div>
          </div>
       </div>
    </form>
     </div>
           </div>

           <div id="oma-tilisiirto" class="tab-pane fade">
             <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
             <div class="row">
                <div class="col-sm-6">
                   <select class="form-control" name="omalta_tililta" style="margin-bottom:20px;">
                    <option>Tililtä</option>
                    <?php foreach($result as $row): ?>
                       <?php if(isset($_SESSION['tililta'])) {$kaytettavaTili =  $_SESSION['tililta'];} ?>
                       <option value="<?= $row['idTili']; ?>" <?= (isset($kaytettavaTili) && $row['idTili'] == $kaytettavaTili) ? 'selected' : '' ?>>
                          <?= $row['TilinNimi']; ?> (<?= $row['Saldo']; ?>)
                       </option>
                       <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm-6">
                   <select class="form-control" name="omalle_tilille" style="margin-bottom:20px;">
                    <option>Tilille</option>
                    <?php foreach($result as $row): ?>
                       <?php if(isset($_SESSION['tililta'])) {$kaytettavaTili =  $_SESSION['tililta'];} ?>
                       <option value="<?= $row['Tilinumero']; ?>" <?= (isset($kaytettavaTili) && $row['idTili'] == $kaytettavaTili) ? 'selected' : '' ?>>
                          <?= $row['TilinNimi']; ?> (<?= $row['Saldo']; ?>)
                       </option>
                       <?php endforeach ?>
                  </select>
                </div>
                </div>
                <div class="row">
               <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">Viesti</div>
                    <div class="panel-body" style="padding:0 0 10px 0;">
                       <div class="form-group">
                        <textarea class="form-control" rows="4" name="viesti" style="border:0;margin:0;" placeholder="Vapaamuotoinen viesti. Ei pakollinen!"></textarea>
                      </div>
                    </div>
                  </div>
               </div>
               <div class="col-sm-6">
                 <div class="input-group">
                    <span class="input-group-addon">Summa</span>
                    <input id="msg" type="text" class="form-control" name="summa" placeholder="0,00">
                 </div>
                 <button type="submit" name="clear-form" class="btn btn-danger btn-block" style="padding:10px 0 10px 0;margin-bottom:20px;">Tyhjennä lomake</button>
                 <button type="submit" name="submit-own-transaction" class="btn btn-new-payment btn-block"><?= (isset($_GET['idELasku'])) ? 'Maksa E-Lasku' : 'Maksa' ?></button>
               </div>
            </div>
         </form>
           </div>
         </div>


        </div>
      </div>
      <?php require_once('template/footer.php'); ?>
    </div>


  </div>
</div>

</body>
</html>
