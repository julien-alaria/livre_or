<?php

require_once '../config/config.php'; 

//Vérifier si l'utilisateur est connecté

if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour écrire un commentaire";
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["commentaire"])) {
    $commentaire = $_POST["commentaire"];
    $user_id = $_SESSION['id']; // Récupérer l'ID de l'utilisateur connecté

    $message = $livre->insererCommentaire($commentaire, $user_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Ajouter un commentaire</title>
</head>
<body>
    <header>
        <?php include 'header.php';?>
    </header>

    <h2>Ajouter un commentaire</h2>

    <form action="" method="POST">
        <textarea name="commentaire" rows="4" cols="50" placeholder="Votre commentaire"></textarea>
        <br>
        <button type="submit">Envoyer</button>
    </form>

</body>
</html>
