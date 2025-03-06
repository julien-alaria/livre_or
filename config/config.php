<?php 

session_start();

include '../classes/database.php';
include '../classes/livre.php';
include '../classes/user.php';

$database = new Database();
$livre = new Livre($database);

$user = (isset($_SESSION["id"])) ? new User(new Database(), $_SESSION['id']) : null;








?>