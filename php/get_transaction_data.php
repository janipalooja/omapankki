<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["idAsiakas"]) && isset($_GET['tili']) && isset($_GET['tapahtuma'])){
   require_once('db_connection.php');

   $sql = $conn->prepare("SELECT * FROM Tilitapahtumat JOIN Tili_Asiakas WHERE idTilitapahtuma = :tapahtuma AND Tili_Asiakas.idAsiakas = :idAsiakas");
   $sql->execute(array('tapahtuma' => $_GET["tapahtuma"], 'idAsiakas' => $_SESSION['idAsiakas']));

   $result = $sql->fetchAll(\PDO::FETCH_ASSOC);
}

?>
