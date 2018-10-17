<div class="col-sm-3 left sidenav">

     <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
       <a href="uusi-maksu.php" role="button" class="btn btn-new-payment btn-block">
         <span>Uusi maksu <i style="padding-left:10px;" class="glyphicon glyphicon-plus"></i></span>
      </a>
     </div>

     <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
        <a href="tilit-ja-kortit.php" role="button" class="btn btn-primary btn-block sidenav-button">Tilit ja Kortit</a>
        <a href="e-laskut.php" role="button" class="btn btn-primary btn-block sidenav-button" style="width:100%;height:42px;">
           <?php require_once('php/get-e-invoices.php'); ?>
           <span style="float:left;">E-Laskut</span>
           <span class="badge badge-custom"><?= (isset($unpaidE_Invoices) && isset($paidE_Invoices)) ? count($unpaidE_Invoices) : '' ?></span>
        </a>
       <a href="omat-tiedot.php" role="button" class="btn btn-primary btn-block sidenav-button">Omat tiedot</a>
       <a href="viestit.php" role="button" class="btn btn-primary btn-block sidenav-button" style="width:100%;height:42px;">
          <span style="float:left;">Viestit</span>
          <span class="badge badge-custom">0</span>
       </a>
     </div>

     <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
         <a href="?logout=true" role="button" class="btn btn-logout btn-block">
         <span>Kirjaudu ulos</span>
         <i style="padding-left:10px;" class="glyphicon glyphicon-log-in"></i>
         </a>
     </div>

</div>
