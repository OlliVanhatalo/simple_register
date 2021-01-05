<?php
  
  // Määritellään tietokantayhteyden muodostamisessa
  // tarvittavat tiedot.
  $dsn = "mysql:host=localhost;dbname=ovanhata;charset=utf8mb4";
  $user = "";
  $pass = "";
  $options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
  ];

  try {
  // Avataan tietokantayhteys luomalla PDO-oliosta
  // ilmentymä.
  $pdo = new PDO($dsn, $user, $pass, $options);
  } catch (PDOException $e) {
  // Avaamisessa tapahtui virhe, tulostetaan
  // virheilmoitus.
  die("ERROR: Could not connect. " . $e->getMessage());
  }
?>