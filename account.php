<?php
// Start the session to access the logged-in user's data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: loginAdmin.php');
    exit();
}

// Sample user data from session
$user_name = $_SESSION['nom']; // User's name
$user_email = $_SESSION['email']; // User's email
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Account Page">
    <meta name="author" content="Your Name">
    <title>Account</title>

    <!-- Include your CSS files -->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body>
    <div class="container">
        <h1>Account Details</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>

        <a href="indexAdmin.php" class="btn btn-primary">Back to Dashboard</a>
        <a href="logoutAdmin.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Include your JavaScript files -->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
</body>

</html>
