<?php 
$db_servername = "localhost";
$db_username = "root";
$db_password = "changeme";
$dbname = "checky";

// Create connection
$conn = new mysqli($db_servername, $db_username, $db_password, $dbname);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
