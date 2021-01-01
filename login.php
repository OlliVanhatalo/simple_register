<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

//Tuodaan tietokantayhteyden luonti ja consoleLog tiedostot. 
  require_once "config.php";
  include "consoleLog.php";

// Sanitoidaan kenttien syötteet ennen kuin tehdään serverikutsu
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Sanitointifunktio. Kaikki syötteet käyvät saman puhdistuspatteriston läpi
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
  // Tarkistetaan jos käyttäjätunnusta ei annettu
  if(empty(test_input($_POST["username"]))){
    $username_err = "Syötä käyttäjätunnus.";
  } else{
    $username = test_input($_POST["username"]);
  }

  // Tarkistetaan jos salasanaa ei annettu
  if(empty(test_input($_POST["password"]))){
    $password_err = "Syötä salasana.";
  } else{
    $password = test_input($_POST["password"]);
  }

  // Validate credentials
  if(empty($username_err) && empty($password_err)){
    //Valmistellaan tietokantakysely
    $sql = "SELECT id, username, password
            FROM users
            WHERE username = :username";

    if($stmt = $pdo->prepare($sql)){
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
      
      // Set parameters
      $param_username = trim($_POST["username"]);
      
      // Attempt to execute the prepared statement
      if($stmt->execute()){
          // Check if name exists, if yes then verify password
          if($stmt->rowCount() == 1){
              if($row = $stmt->fetch()){
                  $id = $row["id"];
                  $username = $row["username"];
                  $hashed_password = $row["password"];
                  if(password_verify($password, $hashed_password)){
                      // Password is correct, so start a new session
                      session_start();
                      
                      // Store data in session variables
                      $_SESSION["loggedin"] = true;
                      $_SESSION["id"] = $id;
                      $_SESSION["username"] = $username;                            
                      
                      // Redirect user to welcome page
                      header("location: index.php");
                  } else{
                      // Display an error message if password is not valid
                      $password_err = "Salasana ei kelpaa.";
                  }
              }
          } else{
              // Display an error message if username doesn't exist
              $username_err = "Käyttäjätunnuksella ei löytynyt tiliä.";
          }
      } else{
          echo "Oppppaaaaa, nyt kävi jotenkin kalpaten. Koitappa myöhemmin uudestaan jookos?";
      }
      // Close statement
      unset($stmt);
    }
  }

  // Suljetaan yhteys
  unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>

</head>
<body>
<div class="wrapper">
  <h2>Kirjautuminen</h2>
  <p>Ole hyvä ja täytä kirjautumistiedot.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">  
      <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <label>Käyttäjätunnus</label>
        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
        <span class="help-block"><?php echo $username_err; ?></span>
      </div>    
      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <label>Salasana</label>
        <input type="password" name="password" class="form-control">
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Kirjaudu">
      </div>
      <p>Eikö sinulla ole vielä käyttäjätiliä? <a href="register.php">Rekisteröidy</a>.</p>
    </form>
</div>

</body>
</html>