<?php
require_once "config.php";
include 'header.php';
include 'consoleLog.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $mess = $_POST['mess'];
   $id = $_SESSION['id'];

   try
   {
      $pdo->setAttribute(PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION
                        );

      // If fields are empty, insert is not triggered
      if (!empty($id) && !empty($mess))
      {

         // Add message to database
         $addMessage = "INSERT INTO message (id, mess, time, date)
                        VALUES (:id, :mess, now(), now());";

         // Add previously added message to thread-table useing last_insert_id
         $addThread = "INSERT INTO thread (messageID, threadID, parentStatus)
                        VALUES ((SELECT LAST_INSERT_ID()), 
                                 (SELECT LAST_INSERT_ID()), 
                                 TRUE);";

         // Preparing of SQL inserts, binding of values
         // and executing prepared statements
         $stmt1  = $pdo->prepare($addMessage);
         $stmt2  = $pdo->prepare($addThread);

         $stmt1->bindValue(":id", $id);
         $stmt1->bindValue(":mess", $mess);
         $stmt2->bindValue(":id", $id);

         $stmt1->execute();
         $stmt2->execute();
      }

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