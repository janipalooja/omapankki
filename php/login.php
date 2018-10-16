<?php

$loginFailed = FALSE;
$requiredValuesNotPassed = FALSE;

$submitLogin = $kayttajatunnus = $salasana = "";

function secure_input($data) {
   // Poistetaan ylimääräiset välilyönnit ja mahd. rivinvaihdot
   $data = trim($data);
   // Poistetaan mahdolliset \ -merkit
   $data = stripslashes($data);
   // Poistetaan käyttäjän syötteestä html-tagit
   $data = htmlspecialchars($data);
   // Palautetaan syöte turvallisessa muodossa
   return $data;
}

// Jos asiakas on painanut Kirjaudu sisään -painiketta suoritetaan toiminnot kirjautumista varten
if(isset($_POST['submit-login']) && $_SERVER["REQUEST_METHOD"] == "POST"){

   // Tehdään kaikista käyttäjän syötteistä turvallisia
   $submitLogin = secure_input($_POST['submit-login']);
   $kayttajatunnus = secure_input($_POST['username']);
   $salasana = secure_input($_POST['password']);

   // Tarkistetaan, että kaikki tiedot on annettu
   $required = array($kayttajatunnus, $salasana);
   for($i = 0; $i < count($required); $i++){
      // Jos jokin vaadittu tieto puuttuu
       if(!$required[$i]){
           $requiredValuesNotPassed = TRUE;
       }
   }

   // Suoritetaan kirjautumisyritys, mikäli käyttäjä on syöttänyt kaikki vaaditut
   if(!$requiredValuesNotPassed){

      // Otetaan yhteys tietokantaan
      require_once('db_connection.php');
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         // SQL-komento palauttaa käyttäjätunnusta vataavan id-numeron ja salasanan
         $sql = $conn->prepare("SELECT idAsiakas, Salasana FROM Asiakkaat WHERE Kayttajatunnus = :kayttajatunnus");
         $sql->execute(array('kayttajatunnus' => $kayttajatunnus));
         $user = $sql->fetch();

            // Tarkistetaan, että vastaako tietokannsata löytynyt salasana käyttäjän syöttämää salasanaa
            if (password_verify($salasana, $user['Salasana'])) {
               // Mikäli salasanat vastaavat toisiaan, niin avataan palvelimelle uusi istuntu
               session_start();
               // Ja tallennetaan asiakkaan id-numero $_SESSION muuttujaan, jota käytetään asiakkaan yksilöimiseksi
               // Tietoa käytetään jatkossa mm- kaikissa käyttäjän tietoihin liittyvissä SQL- kyselyissä käyttäjän yksilöimiseksi
               $_SESSION['idAsiakas'] = $user['idAsiakas'];
               // Suljetaan tietokanta yhteys
               $conn = NULL;

               // ### require_once('save-auth-data.php'); ## TÄÄLLÄ ON JOKU VIRHE!! ###

               // Mikäli käyttäjän syöttämä käyttäjätunnus ja salasana vastaavat tietokantaan talletettuja tunnuksia
               // ohjataan käyttäjä avainluku-sivulle, jota käytetään toisena varmennus- / tunnistusmenetelmänä.
               header("Location: avainluku.php");
               die();
            }
            else {
               // Kirjautuminen epäonnistui, koska annettu käyttäjätunnus tai salasana eivät vastanneet yhtään käyttäjää tietokannassa
               $loginFailed = TRUE;
            }

      // Suljetaan tietokanta yhteys
      $conn = NULL;
   }
   else {
      // Kirjautuminen epäonnistui, koska kaikkia vaadittuja tietoja ei syötetty
      $loginFailed = TRUE;
   }

}

?>
