<?php
require_once('db_connection.php');

$bankAccountNumber = $conn->prepare("SELECT Tilinumero FROM Tilit WHERE idTili = :idTili");
$bankAccountNumber->execute(array('idTili' => $_GET["tili"]));
$tilinumero = $bankAccountNumber->fetchAll(\PDO::FETCH_ASSOC);

$transactionsOUT = $conn->prepare("SELECT * FROM Tilitapahtumat WHERE idTili = :idTili ORDER BY TapahtumanPvm DESC");
$transactionsOUT->execute(array('idTili' => $_GET["tili"]));
$out = $transactionsOUT->fetchAll(\PDO::FETCH_ASSOC);

$transactionsIN = $conn->prepare("SELECT Tilitapahtumat.idTilitapahtuma, CONCAT(Asiakkaat.Etunimi, ' ', Asiakkaat.Sukunimi) AS MaksajanNimi, Tilitapahtumat.TapahtumanPvm, Tilitapahtumat.Summa FROM Tilitapahtumat JOIN Asiakkaat ON Tilitapahtumat.idMaksaja = Asiakkaat.idAsiakas WHERE Tilinumero = :maksettuTilille AND idMaksaja != :tarkasteltavanTilinOmistaja OR Tilinumero = :maksettuTilille AND idMaksaja = :tarkasteltavanTilinOmistaja ORDER BY TapahtumanPvm DESC");
$transactionsIN->execute(array('tarkasteltavanTilinOmistaja' => $_SESSION['idAsiakas'], 'maksettuTilille' => $tilinumero[0]['Tilinumero']));
$in = $transactionsIN->fetchAll(\PDO::FETCH_ASSOC);


?>
