<?php
  // Determine values needed for pdo-connection and open connection
  $dsn = "";
  $user = "";
  $pass = "";
  $options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
  ];

  try {
  $pdo = new PDO($dsn, $user, $pass, $options);
  } catch (PDOException $e) {
  die("ERROR: Could not connect. " . $e->getMessage());
  }
?>