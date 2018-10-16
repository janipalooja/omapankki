<?php
require_once('db_connection.php');

if(isset($_GET['tili']) && isset($_SESSION['idAsiakas'])){
   // Ensimmäisenä haetaan tietokannasta valitun tilin tilinumero, jota käytetään tietojen hakuun Tilitapahtumat-taulusta, joissa maksuvirta on ollut käyttäjän tilille (tilille tuleva raha)
   $bankAccountNumber = $conn->prepare("SELECT Tilinumero FROM Tilit JOIN Tili_Asiakas ON Tilit.idTili = Tili_Asiakas.idTili WHERE Tilit.idTili = :idTili AND Tili_Asiakas.idAsiakas = :idAsiakas");
   $bankAccountNumber->execute(array('idTili' => $_GET["tili"], 'idAsiakas' => $_SESSION["idAsiakas"]));
   $tilinumero = $bankAccountNumber->fetchAll(\PDO::FETCH_ASSOC);

   // Negatiiviset tilitapahtumat, joissa maksuvirta on ollut ulospäin
   $transactionsOUT = $conn->prepare("SELECT * FROM Tilitapahtumat JOIN Tili_Asiakas ON Tilitapahtumat.idTili = Tili_Asiakas.idTili WHERE Tilitapahtumat.idTili = :idTili AND Tili_Asiakas.idAsiakas = :idAsiakas ORDER BY TapahtumanPvm DESC");
   $transactionsOUT->execute(array('idTili' => $_GET["tili"], 'idAsiakas' => $_SESSION["idAsiakas"]));
   $out = $transactionsOUT->fetchAll(\PDO::FETCH_ASSOC);

   // Palvelimen palauttamaa tilinumeroa käytetään ns. positiivisien tilitapahtumien listaukseen, joissa maksu on kohdistunut juuri kyseiseen tilinumeroon
   $transactionsIN = $conn->prepare("SELECT Tilitapahtumat.idTilitapahtuma, CONCAT(Asiakkaat.Etunimi, ' ', Asiakkaat.Sukunimi) AS MaksajanNimi, Tilitapahtumat.TapahtumanPvm, Tilitapahtumat.Summa FROM Tilitapahtumat JOIN Asiakkaat ON Tilitapahtumat.idMaksaja = Asiakkaat.idAsiakas WHERE Tilinumero = :maksettuTilille AND idMaksaja != :tietojaTarkastelevaAsiakas OR Tilinumero = :maksettuTilille AND idMaksaja = :tietojaTarkastelevaAsiakas ORDER BY TapahtumanPvm DESC");
   $transactionsIN->execute(array('tietojaTarkastelevaAsiakas' => $_SESSION['idAsiakas'], 'maksettuTilille' => $tilinumero[0]['Tilinumero']));
   $in = $transactionsIN->fetchAll(\PDO::FETCH_ASSOC);
}


?>
