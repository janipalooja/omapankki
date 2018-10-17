<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["idAsiakas"])){
   include('db_connection.php');

   $sql = $conn->prepare("SELECT Saldo FROM Tilit JOIN Tili_Asiakas ON Tilit.idTili = Tili_Asiakas.idTili WHERE Tili_Asiakas.idAsiakas = :idAsiakas");
   $sql->execute(array('idAsiakas' => $_SESSION["idAsiakas"]));

   $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

   $totalBalance = 0;

   for($i = 0; $i < count($result); $i++){
     $totalBalance += $result[$i]['Saldo'];
   }
}

?>
