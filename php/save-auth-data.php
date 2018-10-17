<?php

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['idAsiakas'])){
   include('db_connection.php');
   $saveAuthInfo = $conn->prepare("INSERT INTO Kirjautumiset (IPosoite, Aika, idAsiakas)
   VALUES (:ip, :aika, :kirjautuja)");

   $saveAuthInfo->bindParam(':ip', get_client_ip());
   $saveAuthInfo->bindParam(':aika', date("Y-m-d H:m:s"));
   $saveAuthInfo->bindParam(':kirjautuja', $_SESSION['idAsiakas']);

   $saveAuthInfo->execute();
}

?>
