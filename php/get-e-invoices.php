<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['idAsiakas'])){
   require_once('db_connection.php');

      $unpaid = $conn->prepare("SELECT * FROM E_Laskut WHERE idAsiakas = :idAsiakas AND MaksettuPvm IS NULL ORDER BY SaapumisPvm DESC");
      $unpaid->execute(array('idAsiakas' => $_SESSION['idAsiakas']));

      $unpaidE_Invoices = $unpaid->fetchAll(\PDO::FETCH_ASSOC);

      $paid = $conn->prepare("SELECT * FROM E_Laskut WHERE idAsiakas = :idAsiakas AND MaksettuPvm IS NOT NULL ORDER BY MaksettuPvm DESC");
      $paid->execute(array('idAsiakas' => $_SESSION['idAsiakas']));

      $paidE_Invoices = $paid->fetchAll(\PDO::FETCH_ASSOC);
}

?>
