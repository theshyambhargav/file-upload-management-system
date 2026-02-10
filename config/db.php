<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "file_manager";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed.");
}
?>