<?php
session_start();

// Security check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: loginAdmin.php');
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "player_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include required files
include('DeletePlayer.php');
include('fetchStat.php');
include('AddPlayer.php');
include('AddMembre.php');
include('AddAdmin.php');

// Get admin info
$user_name = $_SESSION['nom'];
$user_email = $_SESSION['email'];

// Fetch players
$query = "SELECT * FROM players";
$result = $conn->query($query);
$players = [];
while($row = $result->fetch_assoc()) {
    $players[] = $row;
}

// Player statistics
$query = "SELECT COUNT(*) as total FROM players";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$totalPlayers = $row['total'];

// Member statistics
$query = "SELECT * FROM members";
$result = $conn->query($query);
$members = [];
while($row = $result->fetch_assoc()) {
    $members[] = $row;
}

$query = "SELECT COUNT(*) as total FROM members";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$totalMembers = $row['total'];

// Admin statistics
$query = "SELECT * FROM admins";
$result = $conn->query($query);
$admins = [];
while($row = $result->fetch_assoc()) {
    $admins[] = $row;
}

$query = "SELECT COUNT(*) as total FROM admins";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$totalAdmins = $row['total'];

// Notification functions
function getNotifications() {
    return [];
}

function getMessages() {
    return [];
}

function getEmails() {
    return [];
}

$notifications = getNotifications();
$messages = getMessages();
$emails = getEmails();

$unread_notifications_count = count($notifications);
$unread_messages_count = count($messages);
$unread_emails_count = count($emails);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    
    <!-- CSS -->
    <link href="css/font-face.css" rel="stylesheet">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="images/icon/logo.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active">
                            <a href="indexAdmin.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="chart.php"><i class="fas fa-chart-bar"></i>Charts</a>
                        </li>
                        <li>
                            <a href="tables.php"><i class="fas fa-table"></i>Players</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item">
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"><?php echo htmlspecialchars($user_name); ?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="profile.php"><i class="zmdi zmdi-account"></i>Account</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="logout.php"><i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">overview</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="text">
                                                <h2><?php echo $totalPlayers; ?></h2>
                                                <span>Players</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="text">
                                                <h2><?php echo $totalMembers; ?></h2>
                                                <span>Members</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="text">
                                                <h2><?php echo $totalAdmins; ?></h2>
                                                <span>Admins</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>