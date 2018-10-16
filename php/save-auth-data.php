<?php

session_start();
require_once('db_connection.php');

// Function to get the client IP address
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

try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // prepare sql and bind parameters
      $saveAuthInfo = $conn->prepare("INSERT INTO Kirjautumiset (IPosoite, Aika, idAsiakas)
      VALUES (:ip, :aika, :kirjautuja)");

      $saveAuthInfo->bindParam(':ip', get_client_ip());
      $saveAuthInfo->bindParam(':aika', date("Y-m-d H:m:s"));
      $saveAuthInfo->bindParam(':kirjautuja', $_SESSION['idAsiakas']);

      // insert a row
      $saveAuthInfo->execute();

   }
catch(PDOException $e)
   {
   echo $saveAuthInfo . "<br>" . $e->getMessage();
   }

    $conn = NULL;

?>
