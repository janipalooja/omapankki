<?php

include('functions.php');

$keyCodesLeft = randFreeKeyCode('avainlukujaJaljella');

// Asetetaan $_SESSION muuttujiin haluttu haluttua avainlukua vastaava turvatunnus ja avainlukulistan numero
if(!isset($_SESSION['wantedKeyCode']) && $keyCodesLeft > 0){
   $_SESSION['wantedKeyCode'] = randFreeKeyCode('tunnus');
   $_SESSION['wantedKeyCodeList'] = randFreeKeyCode('avainlukulista');
}

   // Tarkista avain luku kirjautumista varten
    if(isset($_POST['submit-keycode-for-login'])){

      include('db_connection.php');

      $keyCodeCheckFailed = FALSE;

      $sql = $conn->prepare("SELECT idAvainluku FROM Avainluvut WHERE Tunnus = :tunnus AND Avainluku = :avainluku AND idAvainlukulista = :avainlukulista");
      $sql->execute(array('tunnus' => $_SESSION['wantedKeyCode'], 'avainluku' => $_POST['keycode'], 'avainlukulista' => $_SESSION['wantedKeyCodeList']));
      $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

      $idAvainluku = 0;

      foreach($result as $row){
         $idAvainluku = $row['idAvainluku'];
      }

      // Jos käyttäjän syöttämä avainluku vastaa tietokannasta löytyvää avainlukua ja turvatunnusta halutulta listalta
      if($idAvainluku > 0){
         // Päivitetään avainluku käytetyksi
         $sql = $conn->prepare("UPDATE Avainluvut SET kaytetty = 1 WHERE idAvainluku = :idAvainluku");
         $sql->execute(array('idAvainluku' => $result[0]['idAvainluku']));
         // Tuhotaan globaalit muuttujat
         unset($_SESSION['wantedKeyCode']);
         unset($_SESSION['wantedKeyCodeList']);
         // Suljetaan tietokanta yhteys ja ohjataan asiakas eteenpäin
         $conn = NULL;
         header("Location: tilit-ja-kortit.php");
      }
      else {
         $keyCodeCheckFailed = TRUE;
      }

   }

   // Tarkistetaan avainluku maksun suorittamista varten
   if(isset($_POST['submit-keycode-for-confirm-transaction'])){

      include('db_connection.php');

      $keyCodeCheckFailed = FALSE;

      $sql = $conn->prepare("SELECT idAvainluku FROM Avainluvut WHERE Tunnus = :tunnus AND Avainluku = :avainluku AND idAvainlukulista = :avainlukulista");
      $sql->execute(array('tunnus' => $_SESSION['wantedKeyCode'], 'avainluku' => $_POST['keycode'], 'avainlukulista' => $_SESSION['wantedKeyCodeList']));
      $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

      $idAvainluku = 0;

      foreach($result as $row){
         $idAvainluku = $row['idAvainluku'];
      }

      // Jos käyttäjän syöttämä avainluku vastaa tietokannasta löytyvää avainlukua ja turvatunnusta halutulta listalta
      if($idAvainluku > 0){
         // Päivitetään avainluku käytetyksi
         $sql = $conn->prepare("UPDATE Avainluvut SET kaytetty = 1 WHERE idAvainluku = :idAvainluku");
         $sql->execute(array('idAvainluku' => $result[0]['idAvainluku']));
         // Tuhotaan globaalit muuttujat
         unset($_SESSION['wantedKeyCode']);
         unset($_SESSION['wantedKeyCodeList']);

         // Luodaan uusi tilitapahtuma ja päivitetään tilien saldo
         addNewTransaction();
         // Suljetaan tietokanta yhteys ja ohjataan asiakas eteenpäin
         $conn = NULL;
         header("Location: tilit-ja-kortit.php");
      }
      else {
         $keyCodeCheckFailed = TRUE;
      }

   }

?>
