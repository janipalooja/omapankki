<?php
require_once('db_connection.php');

$sql = $conn->prepare("SELECT * FROM Tilit JOIN Tili_Asiakas ON Tilit.idTili = Tili_Asiakas.idTili WHERE Tili_Asiakas.idAsiakas = :idAsiakas");
$sql->execute(array('idAsiakas' => $_SESSION["idAsiakas"]));

$result = $sql->fetchAll(\PDO::FETCH_ASSOC);


?>
