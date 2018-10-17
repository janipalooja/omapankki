<?php require_once('php/check-login-state.php'); ?>
<?php define('Viestit', TRUE); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Viestit - OmaPankki</title>
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
          <h4 class="card-title" style="font-size:16px;">Viestit</h4>
         <p style='color:#999;text-align:center;padding:50px 0 50px 0;'><span class='glyphicon glyphicon-search' style='font-size:20px;'></span> </br> Ei viestejä.</p>
        </div>
      </div>
    </div>

    <?php require_once('template/right_sidebar.php'); ?>

  </div>
</div>

<?php require_once('template/mobile-tab-bar.php'); ?>

</body>
</html>
