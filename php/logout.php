<?php
// Tarkisetaan, että onko asiakas painanut Kirjaudu ulos -painiketta
if(isset($_GET['logout']) && $_GET['logout'] == 'true'){
   // Avataan istunto
   session_start();
   // Tuhotaan kaikki avoimet istunnot
   session_destroy();
   // Ohjataan käyttäjä takaisin kirjautumis sivulle
   header("Location: index.php?loggedout=loggedout");
   die();
}
?>
