<?php
require_once('db_connection.php');
require_once('functions.php');

function clearForm(){
   unset($_SESSION['tililta']);
   unset($_SESSION['saajanNimi']);
   unset($_SESSION['summa']);
   unset($_SESSION['saajanTilinumero']);
   unset($_SESSION['erapaiva']);
   unset($_SESSION['viesti']);
   unset($_SESSION['viitenumero']);
}

$transactionFailed = FALSE;
$requiredValuesNotPassed = FALSE;

if(isset($_POST['clear-form'])){

   clearForm();

}

    if(isset($_POST['submit'])){

      if(isset($_POST['idELasku'])){
         $_SESSION['idELasku'] = $_POST['idELasku'];
      }

      $_SESSION['tililta'] = $_POST['tililta'];
      $_SESSION['saajanNimi'] = $_POST['saajanNimi'];
      $_SESSION['summa'] = $_POST['summa'];
      $_SESSION['saajanTilinumero'] = $_POST['saajanTilinumero'];
      $_SESSION['erapaiva'] = $_POST['erapaiva'];
      $_SESSION['viesti'] = $_POST['viesti'];
      $_SESSION['viitenumero'] = $_POST['viitenumero'];

      // Tarkistetaan, että kaikki tiedot on annettu
      $required = array(
         $_POST['tililta'],
         $_POST['saajanNimi'],
         $_POST['summa'],
         $_POST['saajanTilinumero'].
         $_POST['erapaiva']
      );

      for($i = 0; $i < count($required); $i++){
          if(!$required[$i]){
              $requiredValuesNotPassed = TRUE;
          }
      }

      if(!$_POST['viesti'] && !$_POST['viitenumero']){
         $transactionFailed = TRUE;
         $errorMessage = "Anna viitenumero tai viesti.";
      }

      if(!$requiredValuesNotPassed){

         $sql = $conn->prepare("SELECT idTili, Tilinumero FROM Tilit WHERE idTili = :idTili AND Tilinumero = :tilinumero");
         $sql->execute(array('idTili' => $_POST['tililta'], 'tilinumero' => $_POST['saajanTilinumero']));

         $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

         if(count($result) > 0){
            $transactionFailed = TRUE;
            $errorMessage = "Tarkista antamasi tilinumero!";
         }

         if(!$transactionFailed){

            $_SESSION['transactionWaitingConfirm'] = TRUE;

             //clearForm();
             header("Location: avainluku.php");
         }

      }
      else {
         $transactionFailed = TRUE;
         $errorMessage = "Täytä kaikki vaadittavat tiedot.";
      }



   }


   if(isset($_POST['submit-own-transaction'])){
      // NIMEÄ OMAN TILISIIRRON SESSIONIT UUDELLEEN! NE ON NYT SAMOJA KUIN NORMI MAKSUSSA... SIIS MAKSULOMAKKEELLA EHTOLAUSEISSA JNE...

      // Alustetaan muuttujat tyhjään arvoon
      $omalta_tililta = $omalle_tilille = $summa = $viesti = "";

      // Varmistetaan, että kaikki muuttujat ovat turvallisia
      $omalta_tililta = secure_input($_POST["omalta_tililta"]);
      $omalle_tilille = secure_input($_POST["omalle_tilille"]);
      $summa = secure_input($_POST["summa"]);
      $viesti = secure_input($_POST["viesti"]);

      // Tarkistetaan, että kaikki tiedot on annettu
      $required = array(
         $_POST["omalta_tililta"],
         $_POST["omalle_tilille"],
         $_POST["summa"]
      );
      for($i = 0; $i < count($required); $i++){
         // Jos joku vaadituista tiedoista puuttuu
          if(!$required[$i]){
             $transactionFailed = TRUE;
             $errorMessage = "Täytä kaikki vaadittavat tiedot.";
          }
      }

      // Tarkistetaan, että veloitettava tili ei ole sama kuin maksun vastaanottava tili
      include('db_connection.php');
      $sql = $conn->prepare("SELECT Tilinumero FROM Tilit JOIN Tili_Asiakas ON Tilit.idTili = Tili_Asiakas.idTili WHERE Tilit.idTili = :idTili AND Tili_Asiakas.idAsiakas = :idAsiakas");
      $sql->execute(array('idTili' => $omalta_tililta, 'idAsiakas' => $_SESSION['idAsiakas']));
      $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

      if(!$transactionFailed && $result[0]['Tilinumero'] == $omalle_tilille){
         $transactionFailed = TRUE;
         $errorMessage = "Tarkista tilit.";
      }

      // Tarkistaan, että veloitettavalla tilillä riittää katetta
      if(!$transactionFailed && bankAccountBalance($_SESSION['idAsiakas'], $omalta_tililta) < $summa){
         $transactionFailed = TRUE;
         $errorMessage = "Tilin saldo ei riitä.";
      }

      // Mikäli kaikki tarkistukset läpäistään, niin suoritetaan tilisiirto
      if(!$transactionFailed){
         include('db_connection.php');
         $sql = $conn->prepare("SELECT CONCAT(Etunimi, ' ', Sukunimi) AS Nimi FROM Asiakkaat WHERE idAsiakas = :idAsiakas");
         $sql->execute(array('idAsiakas' => $_SESSION["idAsiakas"]));
         $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

         $nimi = $result[0]['Nimi'];

         // Päivitetään tilien saldot
         updateBankAccountBalance($summa, $omalta_tililta, $omalle_tilille);
         // Luodaan uusi tilitapahtuma
         addNewOwnTransaction($nimi, $summa, $omalle_tilille, date("Y-m-d h:i:s"), $viesti, NULL, $_SESSION['idAsiakas'], $omalta_tililta);
      }

   }

?>
