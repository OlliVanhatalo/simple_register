<?php

//Tuodaan tietokantayhteyden luonti. 
require_once "config.php";
include 'header.php';
include 'consoleLog.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // hae data lomakkeelta
   $mess = $_POST['mess'];
   $id = $_SESSION['id'];
   $last_id = 40;
   // $last_id = $pdo->lastInsertId();
   $thread_id = $last_id;
   

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
         // $addMessage .= "SELECT LAST_INSERT_ID();";
         // $addMessage .= "INSERT INTO thread (messageID, threadID, parentStatus)
         //              VALUES (lastInsertId(), :threadID, TRUE);";

         // valmistellaan SQL-lause suoritusta varten
         $stmt1  = $pdo->prepare($addMessage);
         // $stmt2  = $pdo->prepare($addThread);

         $stmt1->bindValue(":id", $id);
         $stmt1->bindValue(":mess", $mess);
         // $stmt1->bindValue(":messageID", $last_id);
         // $stmt1->bindValue(":threadID", $thread_id);

         // suorita lis�yskysely
         $stmt1->execute();
         //tässä häikkää
         // $last_id = $pdo->lastInsertId();
         console_log($last_id);
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