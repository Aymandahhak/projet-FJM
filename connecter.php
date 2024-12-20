<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "player_db";

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  // Log error and display user-friendly message
  error_log("Connection failed: " . $conn->connect_error);
  die("Unable to connect to database. Please try again later.");
}
// Close connection
$conn->close();
