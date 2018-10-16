<?php
require_once('db_connection.php');

$sql = $conn->prepare("SELECT * FROM Tilit WHERE idTili = :idTili");
$sql->execute(array('idTili' => $_GET["tili"]));

$result = $sql->fetchAll(\PDO::FETCH_ASSOC);

$conn = null;

?>
