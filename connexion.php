<?php
session_start(); // Start the session

$host = 'localhost';
$dbname = 'projetg';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is a trainer
    $query_entraineur = "SELECT * FROM entraineur WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query_entraineur);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result_entraineur = $stmt->get_result();

    if ($result_entraineur->num_rows > 0) {
        $entraineur = $result_entraineur->fetch_assoc();
        $_SESSION['user'] = $entraineur['firstname'];
        $_SESSION['role'] = 'coach';
        header("Location: entraineur.php?id=" . $entraineur['id']);
        exit();
    }

    // Check if the user is a player
    $query_joueur = "SELECT * FROM joueurs WHERE email = ? AND password = ?";
    $stmt->prepare($query_joueur);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result_joueur = $stmt->get_result();

    if ($result_joueur->num_rows > 0) {
        $joueur = $result_joueur->fetch_assoc();
        $_SESSION['user'] = $joueur['firstname'];
        $_SESSION['role'] = 'player';
        header("Location: profile_joueur.php?id=" . $joueur['id']);
        exit();
    }

    // Check if the user is an admin
    $query_admin = "SELECT * FROM admins WHERE email = ? AND password = ?";
    $stmt->prepare($query_admin);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result_admin = $stmt->get_result();

    if ($result_admin->num_rows > 0) {
        $admin = $result_admin->fetch_assoc();
        $_SESSION['user'] = $admin['firstname'];
        $_SESSION['role'] = 'admin';
        header("Location: indexAdmin.php?id=" . $admin['id']);
        exit();
    }

    // Incorrect login
    $message = "Identifiants incorrects.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/all.min.css">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<link rel="stylesheet" href="assets/css/animate.css">
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
<section class="vh-100" style=" background: linear-gradient(to right, #008455, #bd2537);">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem; background-color: #07212e;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="assets/img/maroc.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

              <form method="POST" action="">
  <div class="d-flex align-items-center mb-3 pb-1">
    <span class="h1 fw-bold mb-0"><img src="assets/img/logo2.png" alt="logo"></span>
  </div>

  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; color:#fff;">Sign into your account</h5>
  
  <?php if (isset($message)): ?>
    <p class="text-danger"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <div data-mdb-input-init class="form-outline mb-4">
    <input type="email" id="form2Example17" name="email" class="form-control form-control-lg" required />
    <label class="form-label text-white" for="form2Example17">Email address</label>
  </div>

  <div data-mdb-input-init class="form-outline mb-4">
    <input type="password" id="form2Example27" name="password" class="form-control form-control-lg" required />
    <label class="form-label text-white" for="form2Example27">Password</label>
  </div>

  <div class="pt-1 mb-4">
    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
  </div>
  
  <div class="text-center">
    <a href="index.php" class="boxed-btn" style="color: #fff;">Back to Home</a>
    <a href="loginAdmin.php" class="boxed-btn" style="color: #fff;">Admin Login</a>
  </div>

</form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
