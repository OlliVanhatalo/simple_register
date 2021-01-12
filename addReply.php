<?php
//Tuodaan tietokantayhteyden luonti. 
require_once "config.php";
include 'header.php';
include 'consoleLog.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // hae data lomakkeelta
   $mess = $_POST['mess'];
   $id = $_SESSION['id'];
   $quote = $_POST['quote'];
   $thread_id = $_POST['thread'];
   

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
         $addReply = "INSERT INTO message (id, mess, time, date, quote)
                        VALUES (:id, :mess, now(), now(), :quote);";
         
         // lisätään edellä lisätty viesti myös ketju-tauluun käyttäen 
         // session käyttäjän viimeisimpänä lähettämän viestin tietoja
         $addToThread = "INSERT INTO thread (messageID, threadID, parentStatus)
                           VALUES ((SELECT LAST_INSERT_ID()), 
                                    :threadID, 
                                    FALSE);";

         // valmistellaan SQL-lause suoritusta varten
         $stmt1  = $pdo->prepare($addReply);
         $stmt2  = $pdo->prepare($addToThread);

         $stmt1->bindValue(":id", $id);
         $stmt1->bindValue(":mess", $mess);
         $stmt1->bindValue(":quote", $quote);

         $stmt2->bindValue(":threadID", $thread_id);

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