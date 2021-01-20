<?php
include 'header.php';
include 'class.php';
require_once "config.php";
?>

<div class="page-header">
  <div class="header-text">
    <h3>Hei, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Tervetuloa sivuille!</h3>
  </div>
  <div class="header-buttons">
  <p>
    <a href="reset-password.php" class="btn btn-warning">Vaihda salasana</a>
    <a href="logout.php" class="btn btn-danger">Kirjaudu ulos</a>
  </p>
  </div>
</div>

<form method='get'>
  <input type='submit' name='order' class="small-btn" value='Vanhimman mukaan'>
  <input type='submit' name='order' class="small-btn" value='Uusimman mukaan'>
  <input type='submit' name='order' class="small-btn" value='Kirjoittajan mukaan'>
</form>

<?php

try
{
  $pdo->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);

// Switch function gets a value from order-form via get-method.
// Value determines which SQL-inquery is made.
// Inqueries in switch-function are to print all messages
// from database to main content.

  $sql = "";
  $last_thread = array();

  switch ($_GET['order']) {
    case "Vanhimman mukaan":
      $sql = "SELECT message.messageID as id, 
                    users.username as username, 
                    message.mess as mess, 
                    message.time as time, 
                    message.date as date,
                    thread.threadID as thread
              FROM message 
              INNER JOIN users ON message.id = users.id
              INNER JOIN thread ON message.messageID = thread.messageID
              WHERE parentStatus = TRUE
              ORDER BY id asc;";
      break;
    case "Uusimman mukaan":
      $sql = "SELECT message.messageID as id, 
                    users.username as username, 
                    message.mess as mess, 
                    message.time as time, 
                    message.date as date,
                    thread.threadID as thread
              FROM message 
              INNER JOIN users ON message.id = users.id
              INNER JOIN thread ON message.messageID = thread.messageID
              WHERE parentStatus = TRUE
              ORDER BY id desc;";
      break;
    case "Kirjoittajan mukaan":
      $sql = "SELECT message.messageID as id, 
                    users.username as username, 
                    message.mess as mess, 
                    message.time as time, 
                    message.date as date,
                    thread.threadID as thread
              FROM message 
              INNER JOIN users ON message.id = users.id
              INNER JOIN thread ON message.messageID = thread.messageID
              WHERE parentStatus = TRUE
              ORDER BY username asc;";
      break;
    default:
      $sql = "SELECT message.messageID as id, 
                    users.username as username, 
                    message.mess as mess, 
                    message.time as time, 
                    message.date as date,
                    thread.threadID as thread
              FROM message 
              INNER JOIN users ON message.id = users.id
              INNER JOIN thread ON message.messageID = thread.messageID
              WHERE parentStatus = TRUE
              ORDER BY id asc;";

  }

// A second inquery to get data for sub messages and quotes
// in threads

  $sqlThread = "SELECT A.messageID as id, 
                        users.username as username, 
                        A.mess as mess,
                        A.time as time,  
                        A.date as date,
                        A.quote as quote,
                        B.id as user, 
                        C.username as quoteUser,
                        B.mess as quotemess,
                        B.time as quotetime,
                        B.date as quotedate,
                        thread.threadID as thread
                FROM message as A 
                  LEFT JOIN message as B ON B.messageID = A.quote
                  LEFT JOIN users as C ON B.id = C.id
                INNER JOIN users ON A.id = users.id
                INNER JOIN thread ON A.messageID = thread.messageID
                WHERE parentStatus = FALSE AND thread.threadID = :thread 
                ORDER BY id asc;";
    
    $stmt1 = $pdo->prepare($sql);
    $stmt2 = $pdo->prepare($sqlThread);
    $stmt1->execute();
    
    // Messages are printed useing while-loop
    while ( $output = $stmt1->fetchObject() ) {  

        // Predetermined values to be used in message objects
        $messID1 = $output->id;
        $thread = $output->thread;
        $block = new messageBlock();

        $stmt2->bindValue(":thread", $thread);
        $stmt2->execute();

        echo "<div class='thread'>";
        echo "<font size=2><b>";
        echo $output->username . "</b> kirjoitti ";
        echo $output->date . " klo " . substr($output->time, 0, 8);

        echo "</font><p><b>";
        echo $output->mess;
        echo $parentStatus;
        echo "</b></p>";

        echo $block->replyBlock($messID1, $thread);

        while ( $output2 = $stmt2->fetchObject() ) {

          // Predetermined values to be used in message objects
          $messID2 = $output2->id;
          $thread2 = $output2->thread;
          $quote = $output2->quote;
          $block = new messageBlock();

          echo "<div class='reply'>";
          echo "<font size=2><b>";
          echo $output2->username . "</b> vastasi ";
          echo $output2->date . " klo " . substr($output2->time, 0, 8);

          if ($quote != NULL) {

            echo "<div class='quote'>";
            echo "<font size=1><b>";
            echo $output2->quoteUser . "</b> kirjoitti ";
            echo $output2->quotedate . " klo " . substr($output->quotetime, 0, 8);
  
            echo "</font><p><b><q>";
            echo $output2->quotemess;
            echo "</q></b></p></div>";
          }

          echo "</font><p><b>";
          echo $output2->mess;
          echo "</b></p>";
          echo $block->quoteBlock($messID2, $thread2);

          echo "</div>";
        }
 
        echo "</div>";
   
    }
    
    unset($pdo);

}

catch (PDOException $e)
{
   echo $e->getMessage();
   die;
}

include 'footer.php';

?>

