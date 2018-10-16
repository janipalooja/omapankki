<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('db_connection.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $conn->prepare("SELECT * FROM Asiakkaat WHERE idAsiakas = :idAsiakas");
    $sql->execute(array('idAsiakas' => $_SESSION["idAsiakas"]));

    $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

?>
