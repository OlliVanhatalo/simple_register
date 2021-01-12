<?php

//Tuodaan tietokantayhteyden luonti. 
require_once "config.php";
include 'header.php';
include 'consoleLog.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // hae data lomakkeelta ja kirjoittajan id sessiosta
   $mess = $_POST['mess'];
   $id = $_SESSION['id'];

   try
   {
      // puheliaat virheilmoitukset
      $pdo->setAttribute(PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION
                        );

      // tyhjaa ei lisata
      if (!empty($id) && !empty($mess))
      {

         // lisataan lomakkeella oleva viesti vieraskirjan loppuun
         $addMessage = "INSERT INTO message (id, mess, time, date)
                        VALUES (:id, :mess, now(), now());";

         // lisätään edellä lisätty viesti myös ketju-tauluun käyttäen 
         // session käyttäjän viimeisimpänä lähettämän viestin tietoja
         $addThread = "INSERT INTO thread (messageID, threadID, parentStatus)
                        VALUES ((SELECT LAST_INSERT_ID()), 
                                 (SELECT LAST_INSERT_ID()), 
                                 TRUE);";

         // valmistellaan SQL-lause suoritusta varten
         $stmt1  = $pdo->prepare($addMessage);
         $stmt2  = $pdo->prepare($addThread);

         // sidotaan lomakkeen sisältämä viesti ja sessioid 
         // valmisteltuihin kyselyihin
         $stmt1->bindValue(":id", $id);
         $stmt1->bindValue(":mess", $mess);
         $stmt2->bindValue(":id", $id);

         // suoritetaan kyselyt
         $stmt1->execute();
         $stmt2->execute();
      }

      // Suljetaan yhteys
      unset($pdo);   
      header('Location: index.php');

   }
   catch (PDOException $e)
   {
      echo "Lisäys epäonnistui " . $e->getMessage();
      die;
   }
}

?>