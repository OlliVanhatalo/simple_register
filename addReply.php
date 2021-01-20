<?php
require_once "config.php";
include 'header.php';
include 'consoleLog.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $mess = $_POST['mess'];
   $id = $_SESSION['id'];
   $quote = $_POST['quote'];
   $thread_id = $_POST['thread'];
   

   try
   {
      $pdo->setAttribute(PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION
                        );

      // If fields are empty, insert is not triggered
      if (!empty($id) && !empty($mess))
      {

         // Add message to database
         $addReply = "INSERT INTO message (id, mess, time, date, quote)
                        VALUES (:id, :mess, now(), now(), :quote);";
         
         // Add previously added message to thread-table useing last_insert_id
         $addToThread = "INSERT INTO thread (messageID, threadID, parentStatus)
                           VALUES ((SELECT LAST_INSERT_ID()), 
                                    :threadID, 
                                    FALSE);";

         // Preparing of SQL inserts, binding of values
         // and executing prepared statements
         $stmt1  = $pdo->prepare($addReply);
         $stmt2  = $pdo->prepare($addToThread);

         $stmt1->bindValue(":id", $id);
         $stmt1->bindValue(":mess", $mess);
         $stmt1->bindValue(":quote", $quote);

         $stmt2->bindValue(":threadID", $thread_id);

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