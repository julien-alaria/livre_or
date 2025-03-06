<?php

include '../config/config.php';

if(isset($_POST["login_inscription"]) && isset($_POST["password_inscription"])) {
    $login = $_POST["login_inscription"];
    $password = $_POST["password_inscription"];

   $stmt = $database->getConnexion()->prepare("SELECT COUNT(*) FROM user WHERE login = :login");
   $stmt->bindParam(':login', $login);
   $stmt->execute();
   $usernameExists = $stmt->fetchColumn();

   if ($usernameExists > 0) {
       echo "Ce nom d'utilisateur est déjà pris.";
   } else {
  
       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

       $sql = "INSERT INTO user (login, password) VALUES (?, ?)";
       $stmt = $database->getConnexion()->prepare($sql);
       $stmt->bindParam(1, $login);
       $stmt->bindParam(2, $hashedPassword);
       $stmt->execute();
       echo "Utilisateur inscrit en base de donnée.";
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <title>Inscription</title>
</head>
<body>
<header>
        <?php include 'header.php';?>
    </header>
    <h1>Inscription</h1>

    <div class="container_inscription">

        <div class="item_inscription">

            <form action="" method="post">

            <label for="login_inscription">
                <input type="text" name="login_inscription" placeholder="Login" required>
            </label>

            <label for="password_inscription">
                <input type="password" name="password_inscription" placeholder="Password" required>
            </label>

            <button type="submit">Inscription</button>

            </form>

        </div>

    </div>

</body>
</html>
