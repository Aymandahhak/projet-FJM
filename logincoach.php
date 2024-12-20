<?php
session_start(); // Start the session
require_once 'conn.php';
$role = '';

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check that fields are not empty
    if (!empty($email) && !empty($password)) {
        // Search for the user in the database
        $sql = "SELECT * FROM entraineur WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Assign role as 'coach'
            $_SESSION['role'] = 'coach'; // Add this line

            // Redirect to index.php
            header('Location: index.php');
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>
