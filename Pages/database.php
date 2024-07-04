
<?php
// database.php

$host = "127.0.0.1";  // usually "localhost"
$username = "root";
$password = "";
$database = "gighub (2)";

// Create a connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Return the connection object
return $mysqli;
?>