<?php
session_start();

// Clear session data
$_SESSION = [];

// Destroy session
session_destroy();

// Redirect to login page
header('Location: loginAdmin.php');
exit();
