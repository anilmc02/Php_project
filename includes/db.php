<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "root"; // or your MySQL password
$dbname = "school_db"; // ensure this is the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
