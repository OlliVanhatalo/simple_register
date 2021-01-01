<?php
include 'yla.php';
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
  <input type='submit' name='kys' value='Uusimmat ensin'>
  <input type='submit' name='kys' value='Vanhimmat ensin'>
  <input type='submit' name='kys' value='Kirjoittajan mukaan'>
</form>

<?php

try
{
  // puheliaat virheilmoitukset
  $pdo->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);

  // SQL-kielinen hakukysely. Haetaan get metodilla sivulla olevan painikkeen antama arvo,
  // jonka perusteella switch functio määrittelee minkälainen kysely tehdään.

  $kys = "";

  switch ($_GET['kys']) {
    case "Uusimmat ensin":
      $kys = "SELECT message.messageID as id, 
                    users.username as username, 
                    message.mess as mess, 
                    message.time as time, 
                    message.date as date
              FROM message 
              INNER JOIN users ON message.id = users.id
              ORDER BY id asc";
      break;
    case "Vanhimmat ensin":
      $kys = "SELECT message.messageID as id, 
                    users.username as username, 
                    message.mess as mess, 
                    message.time as time, 
                    message.date as date
              FROM message 
              INNER JOIN users ON message.id = users.id
              ORDER BY id desc";
      break;
    case "Kirjoittajan mukaan":
      $kys = "SELECT message.messageID as id, 
                    users.username as username, 
                    message.mess as mess, 
                    message.time as time, 
                    message.date as date
              FROM message 
              INNER JOIN users ON message.id = users.id
              ORDER BY username asc";
      break;
    default:
      $kys = "SELECT message.messageID as id, 
                     users.username as username, 
                     message.mess as mess, 
                     message.time as time, 
                     message.date as date
              FROM message 
              INNER JOIN users ON message.id = users.id
              ORDER BY id asc";
  }
   // valmistellaan SQL-lause suoritusta varten
   $lause = $pdo->prepare($kys);

   // suorita hakukysely
   $lause->execute();


   // haetaan tulokset while-lauseessa
   echo "<hr>";
   while ( $tulos = $lause->fetchObject() )
   {
      echo "<font size=2><b>";
      echo $tulos->username . "</b> kirjoitti ";
      echo $tulos->date . " klo " . substr($tulos->time, 0, 8);

      echo "</font><p><b>";
      echo $tulos->mess;
      echo "</b></p>";
      echo "<button>Vastaa</button><button>Vastaa lainaten</button>";
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

include 'ala.php';

?>

