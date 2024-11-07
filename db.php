<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "kojafi";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "";
}
?>
