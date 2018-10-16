<?php
require_once('db_connection.php');

function secure_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function bankAccountBalance($idAsiakas_, $idTili_){
   include('db_connection.php');
   $sql = $conn->prepare("SELECT Saldo FROM Tilit JOIN Tili_Asiakas ON Tilit.idTili = Tili_Asiakas.idTili WHERE  Tili_Asiakas.idAsiakas = :idAsiakas AND Tili_Asiakas.idTili = :idTili");
   $sql->execute(array('idAsiakas' => $idAsiakas_, 'idTili' => $idTili_));

   $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

   foreach($result as $row){
      $balance = $row['Saldo'];
   }

   return (isset($balance)) ? $balance : '';

   $conn = NULL;
}

function updateBankAccountBalance($summa_, $tililta_, $tilille_){
   include('db_connection.php');
   $summa_ = str_replace(",", ".", $summa_);
   $sql1 = $conn->prepare("UPDATE Tilit SET Saldo = Saldo - :summa WHERE idTili = :tililta");
   $sql1->execute(array('summa' => $summa_, 'tililta' => $tililta_));

   $sql2 = $conn->prepare("UPDATE Tilit SET Saldo = Saldo + :summa WHERE Tilinumero = :tilille");
   $sql2->execute(array('summa' => $summa_, 'tilille' => $tilille_));
   $conn = NULL;
}

function createNewTransaction($saajanNimi_, $summa_, $tilinumero_, $pvm_, $viesti_, $viitenumero_, $maksaja_, $tililta_){
   include('db_connection.php');
   $summa_ = str_replace(",", ".", $summa_);
   $stmt = $conn->prepare("INSERT INTO Tilitapahtumat (SaajanNimi, Summa, Tilinumero, TapahtumanPvm, Viesti, Viitenumero, idMaksaja, idTili)
   VALUES (:saajanNimi, :summa, :tilinumero, :tapahtumanPvm, :viesti, :viitenumero, :maksaja, :tililta)");

   $stmt->bindParam(':saajanNimi', $saajanNimi_);
   $stmt->bindParam(':summa', $summa_);
   $stmt->bindParam(':tilinumero', $tilinumero_);
   $stmt->bindParam(':tapahtumanPvm', $pvm_);
   $stmt->bindParam(':viesti', $viesti_);
   $stmt->bindParam(':viitenumero', $viitenumero_);
   $stmt->bindParam(':maksaja', $maksaja_);
   $stmt->bindParam(':tililta', $tililta_);

   // insert a row
   $stmt->execute();

   $conn = NULL;
}

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
         $omalta_tililta,
         $omalle_tilille,
         $summa
      );
      for($i = 0; $i < count($required); $i++){
         // Jos joku vaadituista tiedoista puuttuu
          if(!$required[$i]){
             $transactionFailed = TRUE;
             $errorMessage = "Täytä kaikki vaadittavat tiedot.";
          }
      }

      // Tarkistetaan, että veloitettava tili ei ole sama kuin maksun vastaanottava tili
      if($omalta_tililta == $omalle_tilille){
         $transactionFailed = TRUE;
         $errorMessage = "Tarkista tilit.";
      }

      // Tarkistaan, että veloitettavalla tilillä riittää katetta
      if(bankAccountBalance($_SESSION['idAsiakas'], $omalta_tililta) < $summa){
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
         createNewTransaction($nimi, $summa, $omalle_tilille, date("Y-m-d h:i:s"), $viesti, NULL, $_SESSION['idAsiakas'], $omalta_tililta);
      }

   }

?>
