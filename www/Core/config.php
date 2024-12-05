<?php
$servername = "mariadb";
$username = "esgi";
$password = "esgipwd";
$dbname = "esgi";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>


