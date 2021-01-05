<?php
//Tuodaan tietokantayhteyden luonti. 
require_once "config.php";
include 'header.php';
include 'consoleLog.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // hae data lomakkeelta
   $mess = $_POST['reply'];
   $id = $_SESSION['id'];
   $last_id = 40;
   // $last_id = $pdo->lastInsertId();
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
         $addReply = "INSERT INTO message (messageID, id, mess, time, date, quote)
                        VALUES (50, :id, :mess, now(), now(), :quote);";
         // $addReply .= "SELECT LAST_INSERT_ID();";
         $addReply .= "INSERT INTO thread (messageID, threadID, parentStatus)
         //              VALUES (lastInsertId(), :threadID, FALSE);";

         // valmistellaan SQL-lause suoritusta varten
         $stmt1  = $pdo->prepare($addMessage);
         // $stmt2  = $pdo->prepare($addThread);

         $stmt1->bindValue(":id", $id);
         $stmt1->bindValue(":mess", $mess);
         // $stmt1->bindValue(":messageID", $last_id);
         $stmt1->bindValue(":quote", $quote);
         $stmt1->bindValue(":threadID", $thread_id);

         // suorita lis�yskysely
         $stmt1->execute();
         //tässä häikkää
         // $last_id = $pdo->lastInsertId();
        
         //tämä ok
         // $stmt2->execute();
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