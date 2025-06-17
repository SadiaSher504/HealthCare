<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "hospital";

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>
