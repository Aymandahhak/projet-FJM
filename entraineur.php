<?php
session_start();

// Include the existing database connection file
require_once "connecter.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$coachId = $_SESSION['user_id'];

// Update functions to use mysqli instead of PDO
function getCoachInfo($conn, $coachId)
{
    $stmt = $conn->prepare("SELECT * FROM entraineur WHERE id = ?");
    $stmt->bind_param("i", $coachId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getDiplomes($conn, $coachId)
{
    $stmt = $conn->prepare("SELECT * FROM diplomes WHERE entraineur_id = ?");
    $stmt->bind_param("i", $coachId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getSpecialisations($conn, $coachId)
{
    $stmt = $conn->prepare("SELECT * FROM specialisations WHERE entraineur_id = ?");
    $stmt->bind_param("i", $coachId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getCarrieres($conn, $coachId)
{
    $stmt = $conn->prepare("SELECT * FROM carrieres WHERE id_entraineur = ?");
    $stmt->bind_param("i", $coachId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getNombreJoueursParTrancheAge($conn, $coachId)
{
    $sql = "SELECT 
            CASE 
                WHEN age BETWEEN 7 AND 10 THEN '7-10 ans'
                WHEN age BETWEEN 11 AND 14 THEN '11-14 ans'
                WHEN age BETWEEN 15 AND 18 THEN '15-18 ans'
                ELSE 'Autres'
            END AS tranche_age,
            COUNT(*) AS nombre_joueurs
        FROM joueurs
        WHERE id_entraineur = ?
        GROUP BY tranche_age";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $coachId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Get coach information using mysqli
$coachInfo = getCoachInfo($conn, $coachId);
$diplomes = getDiplomes($conn, $coachId);
$specialisations = getSpecialisations($conn, $coachId);
$carrieres = getCarrieres($conn, $coachId);
$joueurs_par_age = getNombreJoueursParTrancheAge($conn, $coachId);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Coach</title>
    <link href="css/bootstrap1.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <!-- magnific popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!-- animate css -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/dropmenu.css">

    <style>
        body {
            background-color: rgb(100, 117, 121);
        }

        header {
            background-color: #000;
            /* Noir */
            color: #fff;
            /* Texte blanc pour la lisibilité */
            padding: 10px;
            /* Ajoute un peu d'espacement (facultatif) */
        }

        .main-menu ul li.active a {
            color: #2596c5;
            font-weight: bold;
        }

        .timeline-item {
            position: relative;
            padding-left: 20px;
            border-left: 2px solid #e9ecef;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background-color: #6c757d;
            left: -7px;
            top: 10px;
            border-radius: 50%;
        }

        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body>
    <!-- Navbar (unchanged) -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo">
                            <a href="index.php">
                                <img src="assets/img/logo.png" alt="">
                            </a>
                        </div>
                        <!-- logo -->
                        <!-- menu start -->
                        <nav class="main-menu">
                            <ul>
                                <?php
                                // Define the current page
                                $current_page = basename($_SERVER['PHP_SELF']);
                                ?>
                                <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                                    <a href="index.php">Home</a>
                                </li>
                                <li class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                                    <a href="about.php">About</a>
                                </li>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <li class="<?php echo ($current_page == 'entraineur.php') ? 'active' : ''; ?>">
                                        <a href="entraineur.php">Profile</a>
                                    </li>
                                <?php endif; ?>

                                <li class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                                    <a href="contact.php">Contact</a>
                                </li>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <li class="user-dropdown">
                                        <a href="#" class="user-dropdown-toggle">
                                            <?php echo htmlspecialchars($coachInfo['nom']); ?>
                                            <span class="dropdown-arrow"></span>
                                        </a>
                                        <div class="user-dropdown-menu">
                                            <div class="dropdown-header">My Account</div>
                                            <a href="entraineur.php">
                                                <i class="bi bi-person-circle"></i>Profile
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="logout.php">
                                                <i class="bi bi-box-arrow-right"></i>Log Out
                                            </a>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <div class="header-icons">
                                            <a href="login.php" class="boxed-">Log In</a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                        <div class="mobile-menu"></div>
                        <!-- menu end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
            <!-- Profile Sidebar -->
            <?php
            // Ensure proper escaping function
            function e($string)
            {
                return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
            }
            ?>
            <br><br>
            <div class="col-md-4">
                <div class="card border-0 shadow-lg mb-4 position-sticky top-0">
                    <div class="card-body text-center p-4">
                        <!-- Profile Image Section -->
                        <div class="position-relative d-inline-block mb-3">
                            <img src="<?= e($coachInfo['photo']); ?>"
                                alt="<?= e($coachInfo['nom']); ?>"
                                class="img-fluid rounded-circle shadow-sm"
                                style="width: 200px; height: 200px; object-fit: cover;">

                            <!-- Verified Badge -->
                            <span class="position-absolute bottom-0 end-0 badge bg-primary rounded-circle"
                                style="padding: 0.5rem;">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>

                        <!-- Name Section (Fixed) -->
                        <h2 class="h3 fw-bold mb-2 text-uppercase position-sticky"
                            style="top: 0; background-color: white; z-index: 10;">
                            <?= e(strtoupper($coachInfo['nom'])); ?>
                        </h2>

                        <!-- Personal Information -->
                        <div class="mb-3">
                            <p class="mb-1">
                                <i class="fas fa-birthday-cake me-2 text-secondary"></i>
                                <?= e($coachInfo['age']); ?> ans
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-globe me-2 text-secondary"></i>
                                <?= e($coachInfo['nationalite']); ?>
                            </p>
                            <p>
                                <i class="fas fa-user-tie me-2"></i>
                                <?= e($coachInfo['poste']); ?>
                            </p>
                        </div>

                        <!-- Contact Section -->
                        <div class="d-flex justify-content-center mb-3">
                            <a href="mailto:<?= e($coachInfo['email']); ?>"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-envelope me-2"></i>
                                <?= e($coachInfo['email']); ?>
                            </a>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="suiviejoueurs.php" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i> Suivi des Joueurs
                            </a>
                            <a href="modifierprofile.php" class="btn btn-outline-secondary">
                                <i class="fas fa-edit me-2"></i> Modifier Profil
                            </a>
                        </div>

                        <!-- Statistics Section -->
                        <div class="mt-4">
                            <h5>Statistiques</h5>
                            <div class="d-flex justify-content-around">
                                <div class="text-center ">
                                    <?php if (!empty($joueurs_par_age)): ?>
                                        <?php foreach ($joueurs_par_age as $tranche): ?>
                                            <h6 class="text-primary mb-1"><?= htmlspecialchars($tranche['nombre_joueurs']) ?></h6>
                                            <small class="text-muted">joueurs</small>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <h6 class="text-primary mb-1">0</h6>
                                        <small>joueurs</small>
                                    <?php endif; ?>
                                </div>
                                <div class="text-center">
                                    <h6 class="text-success mb-1"><?= count($diplomes) ?></h6>
                                    <?php ?>
                                    <small class="text-muted">Diplômes</small>
                                </div>

                                <div class="text-center">
                                    <h6 class="text-warning mb-1"><?= count($carrieres) ?></h6>
                                    <small class="text-muted">Clubs</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-md-8">
                <!-- Diplômes Section -->
                <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-graduation-cap me-2"></i>Diplômes
                        </h4>
                        <div class="btn-group" role="group">
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#diplomeModal">
                                <i class="fas fa-plus me-1"></i> Ajouter
                            </button>
                            <button class="btn btn-light btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#modifierDiplomeModal">
                                <i class="fas fa-edit me-1"></i> Modifier
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($diplomes)): ?>
                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                <?php foreach ($diplomes as $dip): ?>
                                    <div class="col">
                                        <div class="bg-light rounded p-3 h-100">
                                            <h6 class="mb-1"><?= htmlspecialchars($dip['titre']); ?></h6>
                                            <p class="text-muted mb-0">Année : <?= htmlspecialchars($dip['annee']); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-light text-center" role="alert">
                                Aucun diplôme trouvé
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Spécialisations Section -->
                <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-star me-2"></i>Spécialisations
                        </h4>

                        <div class="btn-group" role="group">
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#specialisationModal">
                                <i class="fas fa-plus me-1"></i> Ajouter
                            </button>

                            <button class="btn btn-light btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#modifierSpecialisationModal">
                                <i class="fas fa-edit me-1"></i> Modifier
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($specialisations)): ?>
                            <?php foreach ($specialisations as $spec): ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0"><?= htmlspecialchars($spec['nom']); ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($spec['progression']); ?>%</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: <?= htmlspecialchars($spec['progression']); ?>%"
                                            aria-valuenow="<?= htmlspecialchars($spec['progression']); ?>"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-light text-center" role="alert">
                                Aucune spécialisation trouvée
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Carrière Section -->
                <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-trophy me-2"></i>Carrière
                        </h4>
                        <div class="btn-group" role="group">
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#carriereModal">
                                <i class="fas fa-plus me-1"></i> Ajouter
                            </button>
                            <button class="btn btn-light btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#modifierCarriereModal">
                                <i class="fas fa-edit me-1"></i> Modifier
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($carrieres)): ?>
                            <div class="timeline">
                                <?php foreach ($carrieres as $car): ?>
                                    <div class="timeline-item mb-3">
                                        <div class="timeline-content bg-light rounded p-3">
                                            <h6 class="mb-1"><?= htmlspecialchars($car['club']); ?></h6>
                                            <p class="text-muted mb-0"><?= htmlspecialchars($car['description']); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-light text-center" role="alert">
                                Aucune expérience trouvée
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pour Diplôme -->
    <div class="modal fade" id="diplomeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Diplôme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="ajouterinformation.php">
                        <div class="mb-3">
                            <label for="diplome_titre" class="form-label">Titre du diplôme</label>
                            <input type="text" class="form-control" id="diplome_titre" name="diplome_titre" required>
                        </div>
                        <div class="mb-3">
                            <label for="diplome_annee" class="form-label">Année d'obtention</label>
                            <input type="number" class="form-control" id="diplome_annee" name="diplome_annee" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pour Spécialisation -->
    <div class="modal fade" id="specialisationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une spécialisation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="ajouterinformation.php">
                        <div class="mb-3">
                            <label for="specialisation_nom" class="form-label">Nom de la spécialisation</label>
                            <input type="text" class="form-control" id="specialisation_nom" name="specialisation_nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="specialisation_niveau" class="form-label">Niveau (%)</label>
                            <input type="range" class="form-range" id="specialisation_niveau" name="specialisation_niveau" min="0" max="100" step="5" oninput="this.nextElementSibling.value = this.value + '%'">
                            <output>50%</output>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pour Carrière -->
    <div class="modal fade" id="carriereModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une expérience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="ajouterinformation.php">
                        <div class="mb-3">
                            <label for="carriere_club" class="form-label">Club</label>
                            <input type="text" class="form-control" id="carriere_club" name="carriere_club" required>
                        </div>
                        <div class="mb-3">
                            <label for="carriere_description" class="form-label">Description</label>
                            <textarea class="form-control" id="carriere_description" name="carriere_description" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modifierDiplomeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier un Diplôme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="modifierinformation.php">
                        <div class="mb-3">
                            <label for="modifier_diplome_selection" class="form-label">Sélectionner le diplôme à modifier</label>
                            <select class="form-select" id="modifier_diplome_selection" name="modifier_diplome_selection" required>
                                <?php foreach ($diplomes as $dip): ?>
                                    <option value="<?= htmlspecialchars($dip['id']); ?>">
                                        <?= htmlspecialchars($dip['titre']); ?> (<?= htmlspecialchars($dip['annee']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modifier_diplome_titre" class="form-label">Nouveau titre du diplôme</label>
                            <input type="text" class="form-control" id="modifier_diplome_titre" name="modifier_diplome_titre">
                        </div>
                        <div class="mb-3">
                            <label for="modifier_diplome_annee" class="form-label">Nouvelle année d'obtention</label>
                            <input type="number" class="form-control" id="modifier_diplome_annee" name="modifier_diplome_annee">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modifierSpecialisationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier une Spécialisation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="modifierinformation.php">
                        <div class="mb-3">
                            <label for="modifier_specialisation_selection" class="form-label">Sélectionner la spécialisation à modifier</label>
                            <select class="form-select" id="modifier_specialisation_selection" name="modifier_specialisation_selection" required>
                                <?php foreach ($specialisations as $spec): ?>
                                    <option value="<?= htmlspecialchars($spec['id']); ?>">
                                        <?= htmlspecialchars($spec['nom']); ?> (<?= htmlspecialchars($spec['progression']); ?>%)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modifier_specialisation_nom" class="form-label">Nouveau nom de la spécialisation</label>
                            <input type="text" class="form-control" id="modifier_specialisation_nom" name="modifier_specialisation_nom">
                        </div>
                        <div class="mb-3">
                            <label for="modifier_specialisation_niveau" class="form-label">Nouveau niveau (%)</label>
                            <input type="range" class="form-range" id="modifier_specialisation_niveau" name="modifier_specialisation_niveau" min="0" max="100" step="5" oninput="this.nextElementSibling.value = this.value + '%'">
                            <output>50%</output>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modifierCarriereModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier une Expérience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="modifierinformation.php">
                        <div class="mb-3">
                            <label for="modifier_carriere_selection" class="form-label">Sélectionner l'expérience à modifier</label>
                            <select class="form-select" id="modifier_carriere_selection" name="modifier_carriere_selection" required>
                                <?php foreach ($carrieres as $car): ?>
                                    <option value="<?= htmlspecialchars($car['id_carreire']); ?>">
                                        <?= htmlspecialchars($car['club']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modifier_carriere_club" class="form-label">Nouveau nom du club</label>
                            <input type="text" class="form-control" id="modifier_carriere_club" name="modifier_carriere_club">
                        </div>
                        <div class="mb-3">
                            <label for="modifier_carriere_description" class="form-label">Nouvelle description</label>
                            <textarea class="form-control" id="modifier_carriere_description" name="modifier_carriere_description" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title">À propos de mon profil</h2>
                        <p>Découvrez mon parcours professionnel, mes compétences et mes réalisations. Je suis passionné par mon domaine et toujours à la recherche de nouveaux défis.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box get-in-touch">
                        <h2 class="widget-title">Me contacter</h2>
                        <ul>
                            <li>Localisé à : [Votre ville/région]</li>
                            <li>contact@monprofil.com</li>
                            <li>+212 6 XX XX XX XX</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box pages">
                        <h2 class="widget-title">Navigation</h2>
                        <ul>
                            <li><a href="index.php">Accueil</a></li>
                            <li><a href="about.php">À propos</a></li>
                            <li><a href="entraineur.php">Mon Profil</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box subscribe">
                        <h2 class="widget-title">Restons connectés</h2>
                        <p>Abonnez-vous pour recevoir mes dernières mises à jour et actualités professionnelles.</p>
                        <form action="index.php">
                            <input type="email" placeholder="Votre email">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- count down -->
    <script src="assets/js/jquery.countdown.js"></script>
    <!-- isotope -->
    <script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
    <!-- waypoints -->
    <script src="assets/js/waypoints.js"></script>
    <!-- owl carousel -->
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- magnific popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
    <script src="assets/js/jquery.meanmenu.min.js"></script>
    <!-- sticker js -->
    <script src="assets/js/sticker.js"></script>
    <!-- main js -->
    <script src="assets/js/main.js"></script>
</body>

</html>