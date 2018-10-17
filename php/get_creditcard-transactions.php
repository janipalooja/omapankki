<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["idAsiakas"])){
   require_once('db_connection.php');

   $sql = $conn->prepare("SELECT Luottokorttitapahtumat.TapahtumaPvm AS Pvm, Luottokorttitapahtumat.Selite AS Selite, Luottokorttitapahtumat.Summa AS Summa, Kortit.KortinNimi AS KortinNimi FROM Luottokorttitapahtumat JOIN Kortit ON Luottokorttitapahtumat.idKortti = Kortit.idKortti WHERE Luottokorttitapahtumat.idKortti = :idKortti AND Kortit.idAsiakas = :idAsiakas");
   $sql->execute(array('idKortti' => $_GET["idKortti"], 'idAsiakas' => $_SESSION["idAsiakas"]));
   $result = $sql->fetchAll(\PDO::FETCH_ASSOC);
}

?>
