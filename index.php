<?php
include 'header.php';
require_once "config.php";
?>

<div class="page-header">
        <h3>Hei, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Tervetuloa sivuille!</h3>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Vaihda salasana</a>
        <a href="logout.php" class="btn btn-danger">Kirjaudu ulos</a>
    </p>


<form method='get'>
  <input type='submit' name='order' value='Uusimmat ensin'>
  <input type='submit' name='order' value='Vanhimmat ensin'>
  <input type='submit' name='order' value='Kirjoittajan mukaan'>
</form>

<?php

try
{
  // puheliaat virheilmoitukset
  $pdo->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);

  // SQL-kielinen hakukysely. Haetaan get metodilla sivulla olevan painikkeen antama arvo,
  // jonka perusteella switch functio määrittelee minkälainen kysely tehdään.

  $sql = "";
  $last_thread = array();

  switch ($_GET['order']) {
    case "Uusimmat ensin":
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
    case "Vanhimmat ensin":
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

  $sqlThread = "SELECT message.messageID as id, 
                      users.username as username, 
                      message.mess as mess, 
                      message.time as time, 
                      message.date as date,
                      thread.threadID as thread
                FROM message 
                INNER JOIN users ON message.id = users.id
                INNER JOIN thread ON message.messageID = thread.messageID
                WHERE parentStatus = FALSE AND thread.threadID = :thread
                ORDER BY id asc;";
    // valmistellaan SQL-lause suoritusta varten
    $stmt1 = $pdo->prepare($sql);
    $stmt2 = $pdo->prepare($sqlThread);

    // suorita hakukysely
    $stmt1->execute();
    
    // haetaan tulokset while-lauseessa
    echo "<hr>";
    while ( $output = $stmt1->fetchObject() ) {
        // määritetään kunkin syklin viestiketjun threadID, sidotaan sen arvo stmt2 kyselyn ":thread" arvoon
        // ja suoritetaan tietokantakysely
        $thread = $output->thread;
        $stmt2->bindValue(":thread", $thread);
        $stmt2->execute();

        echo "<div class='thread'>";
        echo "<font size=2><b>";
        echo $output->username . "</b> kirjoitti ";
        echo $output->date . " klo " . substr($output->time, 0, 8);

        echo "</font><p><b>";
        echo $output->mess;
        echo "</b></p>";
        echo "<button>Vastaa</button><button>Vastaa lainaten</button>";
        
        
        while ( $output2 = $stmt2->fetchObject() ) {
          echo "<div class='reply'>";
          echo "<font size=2><b>";
          echo $output2->username . "</b> kirjoitti ";
          echo $output2->date . " klo " . substr($output2->time, 0, 8);

          echo "</font><p><b>";
          echo $output2->mess;
          echo "</b></p>";
          echo "<button>Vastaa</button><button>Vastaa lainaten</button>";
          echo "</div>";
        }
        echo "</div>";
        echo "<HR>";
    }
    // suljetaan tietokantayhteys tuhoamalla yht-olio
    unset($pdo);

}

catch (PDOException $e)
{
   echo $e->getMessage();
   die;
}

include 'footer.php';

?>

