<?php
session_start();
if (!isset($_SESSION['idAsiakas'])){
   header("Location: index.php");
   die();
}
?>
