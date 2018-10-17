
<div class="col-sm-3 right sidenav">

<?php if(defined('TilitJaKortit') || defined('E_Laskut') || defined('Luottokorttitapahtumat') || defined('OmatTiedot') || defined('Viestit')): ?>
<?php require_once('php/get_userdata.php'); ?>
   <?php foreach($result as $row): ?>
   <div class="card">
     <div class="card-body" style="background-color:#0099FF;border:1px #0099FF solid;">
       <h5 class="card-title" style="font-size:12px;color:#fff;"><i>Tervetuloa</i></h5>
       <p style="font-size:28px;text-align:right;color:#fff;"><?= $row['Etunimi'] ?> <?= $row['Sukunimi'] ?></p>
       <?php require_once('php/last-login.php'); ?>
       <?php if(isset($result[0]['Aika'])){$lastLoginDate = date("d.m.Y", strtotime($result[0]['Aika'])); }?>
       <?php $lastLoginTime = date("H.m", strtotime($result[0]['Aika'])); ?>
       <?php if($result[0]['Aika']): ?>
          <span style="font-size:11px;"><i>Edellinen kirjautuminen <?= $lastLoginDate ?> klo <?= $lastLoginTime ?></i></span>
       <?php endif ?>
       <?php if(!$result[0]['Aika']): ?>
          <span style="font-size:11px;"><i>Tervetuloa ensimmäistä kertaa!</i></span>
       <?php endif ?>
     </div>
   </div>
   <?php endforeach ?>

<?php require_once('php/get_account_balance.php'); ?>
   <div class="card">
     <div class="card-body" style="background-color:#00CC99;border:1px #00CC99 solid;">
       <h5 class="card-title" style="font-size:12px;color:#fff;"><i>Varat</i></h5>
       <p style="font-size:28px;text-align:right;color:#fff;margin-bottom:30px;">+ <?= number_format($totalBalance, 2, ',', ' ') ?> €</p>
     </div>
   </div>

   <div class="card">
     <div class="card-body" style="background-color:#FF6666;border:1px #FF6666 solid;">
       <h5 class="card-title" style="font-size:12px;color:#fff;"><i>Velat</i></h5>
       <p style="font-size:28px;text-align:right;color:#fff;margin-bottom:30px;">- 0,00 €</p>
     </div>
   </div>
   <?php endif ?>

   <?php if(defined('Tilitapahtumat')): ?>
      <?php require_once('php/get_account_data.php'); ?>
         <?php foreach($result as $row): ?>
         <div class="card">
           <div class="card-body">
             <p style="font-size:16px;color:#666;"><?= $row['TilinNimi'] ?></p>
             <p style="font-size:13px;color:#666;"><?= $row['Tilinumero'] ?></p>
             <p style="font-size:13px;color:#666;">Saldo: <b style="float:right;"><?= number_format($row['Saldo'], 2, ',', ' ') ?> €</b></p>
           </div>
         </div>
         <?php endforeach ?>
   <?php endif ?>

</div>
