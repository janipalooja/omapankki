<?php
include('db_connection.php');

$sql = $conn->prepare("SELECT * FROM Kortit WHERE idAsiakas = :idAsiakas;");
$sql->execute(array('idAsiakas' => $_SESSION["idAsiakas"]));

$result = $sql->fetchAll(\PDO::FETCH_ASSOC);

$conn = null;

?>
