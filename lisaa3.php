<?php

//Tuodaan tietokantayhteyden luonti. 
require_once "config.php";
include 'yla.php';
include 'consoleLog.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   // hae data lomakkeelta
   $mess = $_POST['mess'];
   $id = $_SESSION['id'];
   $test_id = $_SESSION['id'];
   $last_id = $pdo->lastInsertId();

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
         $addThread = "INSERT INTO thread (messageID, threadID)
                      VALUES (:messageID, :threadID);";

         // valmistellaan SQL-lause suoritusta varten
         $stmt1  = $pdo->prepare($addMessage);
         $stmt2  = $pdo->prepare($addThread);

         $stmt1->bindValue(":id", $id);
         $stmt1->bindValue(":mess", $mess);
         $stmt2->bindValue(":messageID", $test_id);
         $stmt2->bindValue(":threadID", $last_id);
         // $stmt3->bindValue(2, $last_id);

         // suorita lis�yskysely
         $stmt1->execute();
         //tässä häikkää
         // $last_id = $pdo->lastInsertId();
         //tämä ok
         $stmt2->execute();
      }
      // tyhjennet��n muuttujat
      // t�m� simppeli jippo est�� selaimen "p�ivit�"-painiketta lis��m�st� samaa viesti� uudelleen
      // fiksumpi tapa on k�ytt�� $_SESSION
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