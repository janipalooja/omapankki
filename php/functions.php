<?php
function randFreeKeyCode($paluuArvo){
   include('db_connection.php');
   // Haetaan tietokannasta kaikki käyttäjän avainlukulistat ja niissä olevat ”turvatunnukset”
   $sql = $conn->prepare("SELECT Avainluvut.Tunnus, Avainlukulistat.idAvainlukulista FROM Avainluvut JOIN Avainlukulistat ON Avainlukulistat.idAvainlukulista = Avainluvut.idAvainlukulista WHERE Avainlukulistat.idAsiakas = :idAsiakas AND kaytetty = :kaytetty");
   $sql->execute(array('idAsiakas' => $_SESSION['idAsiakas'], 'kaytetty' => 0));
   $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

   $keyCodesLeft = count($result);
   if($keyCodesLeft == 0) $max = 0;
   else $max = $keyCodesLeft-1;
   $random = mt_rand(0, $max);

   if($paluuArvo == 'tunnus')
   return $result[$random]['Tunnus'];
   else if($paluuArvo == 'avainlukulista')
   return $result[$random]['idAvainlukulista'];
   else if($paluuArvo == 'avainlukujaJaljella')
   return $keyCodesLeft;
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

function addNewTransaction(){
   include('db_connection.php');

   // Lisää uusi tilitapahtuma
   $stmt = $conn->prepare("INSERT INTO Tilitapahtumat (SaajanNimi, Summa, Tilinumero, TapahtumanPvm, Viesti, Viitenumero, idMaksaja, idTili)
   VALUES (:saajanNimi, :summa, :tilinumero, :tapahtumanPvm, :viesti, :viitenumero, :maksaja, :tililta)");

   if(isset($_SESSION['saajanNimi']))
   $stmt->bindParam(':saajanNimi', $_SESSION['saajanNimi']);

   if(isset($_SESSION['summa']))
   $summa = str_replace(",", ".", $_SESSION['summa']);
   $stmt->bindParam(':summa', $summa);

   if(isset($_SESSION['saajanTilinumero']))
   $tilinumero = preg_replace('/\s+/', '', $_SESSION['saajanTilinumero']);
   $stmt->bindParam(':tilinumero', $tilinumero);

   $tapahtumanPVM = date("Y-m-d h:i:s");
   $stmt->bindParam(':tapahtumanPvm', $tapahtumanPVM);

   if(isset($_SESSION['viesti']))
   $stmt->bindParam(':viesti', $_SESSION['viesti']);

   if(isset($_SESSION['viitenumero']))
   $viitenumero = preg_replace('/\s+/', '', $_SESSION['viitenumero']);
   $stmt->bindParam(':viitenumero', $viitenumero);

   if(isset($_SESSION['idAsiakas']))
   $stmt->bindParam(':maksaja', $_SESSION['idAsiakas']);

   if(isset($_SESSION['tililta']))
   $stmt->bindParam(':tililta', $_SESSION['tililta']);

   // insert a row
   $stmt->execute();

   updateBankAccountBalance($summa, $_SESSION['tililta'], $tilinumero);

   unset($_SESSION['tililta']);
   unset($_SESSION['saajanNimi']);
   unset($_SESSION['summa']);
   unset($_SESSION['saajanTilinumero']);
   unset($_SESSION['erapaiva']);
   unset($_SESSION['viesti']);
   unset($_SESSION['viitenumero']);

   if(isset($_SESSION['idELasku'])){

      $sql = "UPDATE E_Laskut SET MaksettuPvm = '2018-10-14' WHERE idELasku = :idELasku AND MaksettuPvm IS NULL AND idAsiakas = :idAsiakas";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':idELasku', $_SESSION['idELasku']);
      $stmt->bindParam(':idAsiakas', $_SESSION['idAsiakas']);

      $stmt->execute();
   }

   unset($_SESSION['idELasku']);
}

?>
