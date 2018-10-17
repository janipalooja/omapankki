<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['idAsiakas'])){
include('db_connection.php');
$sql = $conn->prepare("SELECT * FROM Asiakkaat WHERE idAsiakas = :idAsiakas");
$sql->execute(array('idAsiakas' => $_SESSION["idAsiakas"]));

$result = $sql->fetchAll(\PDO::FETCH_ASSOC);
}

?>
