<?php

date_default_timezone_set("Europe/Helsinki");

if (session_status() == PHP_SESSION_NONE){
   session_start();
}

$servername = "";
$dbname = "";
$username = "";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->query('SET CHARACTER SET utf8');
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

?>
