<?php require_once('php/check_key_code.php'); ?>
<?php require_once('php/logout.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Vahvista toiminto - OmaPankki</title>
<?php require_once('template/head.php'); ?>
</head>
<body>

<?php $noMobileNavbar = TRUE; require_once('template/navbar.php'); ?>

<div id="container" class="container-fluid text-center">
   <div class="row content text-left">
      <div class="col-sm-12">
         <div class="panel-group login-form">

               <div class="error-msq-base">
                  <?php if(isset($keyCodeCheckFailed) && $keyCodeCheckFailed): ?>
                  <div class="alert alert-danger alert-dismissible fade in">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Virhe!</strong> Tarkista antamasi avainluku.
                  </div>
                  <?php endif ?>
               </div>

             <div class="panel panel-default animated <?= ($keyCodeCheckFailed) ? shake : noAnimate ?>">
               <div class="panel-heading">Vahvista toiminto</div>
               <div class="panel-body">
                  <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                     <div class="give-keycode-txt"><span>Anna tunnusta <b><?= (isset($_SESSION['wantedKeyCode'])) ? $_SESSION['wantedKeyCode'] : '' ?></b> vastaava avainluku.</span></div>
                     <div class="input-group">
                        <span class="input-group-addon"><?= ($keyCodesLeft != 0) ? $_SESSION['wantedKeyCode'] : '<b class="key-code-x">X</b>' ?> =</span>
                        <input type="text" class="form-control" name="keycode" placeholder="Avainluku" required autofocus>
                     </div>
                     <div class="out-of-keycodes"><span><?= ($keyCodesLeft == 0) ? "<b>Avainluvut loppu! Tilaa uusi lista pankista.</b>" : "Sinulla on jäljellä $keyCodesLeft/10 avainlukua." ?></span></div>
                  <div class="btn-group btn-group-justified">
                     <div class="btn-group">
                        <?php if(!isset($_SESSION['transactionWaitingConfirm'])): ?>
                        <button type="submit" name="submit-keycode-for-login" class="btn btn-primary confirm-key-code-btn" <?= ($keyCodesLeft == 0) ? "disabled" : "" ?>>Vahvista</button>
                        <?php endif ?>
                        <?php if(isset($_SESSION['transactionWaitingConfirm'])): ?>
                        <button type="submit" name="submit-keycode-for-confirm-transaction" class="btn btn-primary confirm-key-code-btn" <?= ($keyCodesLeft == 0) ? "disabled" : "" ?>>Vahvista</button>
                        <?php endif ?>
                     </div>
                     <div class="btn-group">
                        <?php if(!isset($_SESSION['transactionWaitingConfirm'])): ?>
                        <a href="?logout=true" class="btn btn-primary abort-function-btn">Keskeytä</a>
                        <?php endif ?>
                        <?php if(isset($_SESSION['transactionWaitingConfirm'])): ?>
                        <a href="uusi-maksu.php" class="btn btn-primary abort-function-btn">Keskeytä</a>
                        <?php endif ?>
                     </div>
                  </div>
                  </form>
               </div>
             </div>

            <div id="footer">
               <p>Copyright 2018 &copy; Ryhmä-C</p>
            </div>

         </div> <!-- .panel-group login-form -->
      </div> <!-- .col-sm-12 -->
   </div> <!-- .row content text-left -->
</div> <!-- #container -->

</body>

</html>
