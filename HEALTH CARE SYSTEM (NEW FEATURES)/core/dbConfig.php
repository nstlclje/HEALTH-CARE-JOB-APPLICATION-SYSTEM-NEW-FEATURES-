<?php

$host = 'localhost';
$db = 'job_app';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Could not connect to the database $db using PDO: " . $e->getMessage());
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job_app";

$conn = new mysqli($servername, $username, $password, $dbname);

?>
