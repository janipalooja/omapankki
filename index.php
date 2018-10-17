<?php
session_start();
if (isset($_SESSION['idAsiakas'])){
   header("Location: tilit-ja-kortit.php");
   die();
}
?>
<?php require_once('php/login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tervetuloa! - OmaPankki</title>
<?php require_once('template/head.php'); ?>
</head>
<body>

<?php $noMobileNavbar = TRUE; require_once('template/navbar.php'); ?>

<div id="container" class="container-fluid text-center">
   <div class="row content text-left">
      <div class="col-sm-12">
         <div class="panel-group login-form">

               <div class="error-msq-base">
                  <?php if(isset($loginFailed) && $loginFailed): ?>
                  <div class="alert alert-danger alert-dismissible fade in">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Virhe!</strong> Väärä käyttäjätunnus tai salasana.
                  </div>
                  <?php endif ?>

                  <?php if(isset($_GET['loggedout']) && $_GET['loggedout'] == 'loggedout'): ?>
                  <div class="alert alert-success alert-dismissible fade in">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     Olet nyt kirjautunut ulos. Tervetuloa uudelleen!
                  </div>
                  <?php endif ?>
               </div> <!-- error-msq-base -->

            <div class="panel panel-default animated <?= ($loginFailed) ? shake : noAnimate ?>">
               <div class="panel-heading">Kirjaudu verkkopankkiin</div>
               <div class="panel-body">
                  <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Käyttäjätunnus" required autofocus>
                     </div>
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Salasana" required>
                     </div>
                     <div class="input-group login-btn-group">
                        <button type="submit" name="submit-login" class="btn btn-primary btn-block login-btn">Kirjaudu sisään</button>
                     </div>
                  </form>
               </div>
            </div> <!-- panel -->

            <?php require_once('template/footer.php'); ?>

         </div> <!-- .panel-group login-form -->
      </div> <!-- .col-sm-12 -->
   </div> <!-- .row content text-left -->
</div> <!-- #container -->

</body>

</html>
