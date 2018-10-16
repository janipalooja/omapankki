<div class="col-sm-3 left sidenav">

     <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
       <a href="uusi-maksu.php" role="button" class="btn btn-new-payment btn-block">
         <span>Uusi maksu</span>
         <span class="glyphicon glyphicon-plus"></span>
      </a>
     </div>

     <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
        <a href="tilit-ja-kortit.php" role="button" class="btn btn-primary btn-block sidenav-button">Tilit ja Kortit</a>
        <a href="e-laskut.php" role="button" class="btn btn-primary btn-block sidenav-button">
           <?php require_once('php/get-e-invoices.php'); ?>
           E-Laskut <span class="badge badge-custom"><?= (isset($unpaidE_Invoices) && isset($paidE_Invoices)) ? count($unpaidE_Invoices) : '' ?></span>
        </a>
       <button type="button" class="btn btn-primary btn-block sidenav-button">Omat tiedot</button>
       <button type="button" class="btn btn-primary btn-block sidenav-button">Viestit <span class="badge badge-custom">0</span></button>
     </div>

     <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
         <a href="?logout=true" role="button" class="btn btn-logout btn-block">
         <span>Kirjaudu ulos</span>
         <span class="glyphicon glyphicon-log-in"></span>
         </a>
     </div>

</div>
