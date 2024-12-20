<?php
require_once 'conn.php';
require_once 'joueurs.php';


session_start();
$coachId = $_SESSION['user_id'];
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">Mise à jour réussie!</div>';
} elseif (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">Erreur de la mise à jour.</div>';
}

$stats = getStatistics($coachId);

// Récupérer le filtre (actif, blessé, etc.)
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Récupérer la recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Récupérer les joueurs
$players = getAllPlayers($filter,$coachId);

// Filtrage par recherche
if ($search) {
    $players = array_filter($players, function($player) use ($search) {
        return stripos($player['nom'], $search) !== false;
    });
}






// Configuration de la pagination
$players_per_page = 6;
$total_players = count($players);
$total_pages = ceil($total_players / $players_per_page);
$current_page = isset($_GET['page']) ? max(1, min($total_pages, intval($_GET['page']))) : 1;
$offset = ($current_page - 1) * $players_per_page;

// Récupérer seulement les joueurs de la page courante
$players_page = array_slice($players, $offset, $players_per_page);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Joueurs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styliserjou.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
        <img src="images/logobike.png" alt="Logo" height="50"> 
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
            <a class="nav-link text-light" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
            </li>
        </ul>
        </div>
    </div>
    </nav>


<div class="container">
<div class="container-fluid" id="suivie">
        <div class="d-flex justify-content-between align-items-center">
            <div class="m-2">
                <h1>Suivi des Joueurs</h1>
                <p class="mb-0">Tableau de bord de performance</p>
            </div>
            <a href="entraineur.php" class="btn btn-light m-2">
                <i class="fas fa-arrow-left me-2"></i>Retour au profil
            </a>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="quick-stats">
        <div class="row text-center">
            <div class="col-md-3">
                <h4><?php echo $stats['active_players']; ?></h4>
                <p class="mb-0">Joueurs actifs</p>
            </div>
            <div class="col-md-3">
                <h4><?php echo $stats['injured_players']; ?></h4>
                <p class="mb-0">Blessés</p>
            </div>
            <div class="col-md-3">
                <h4><?php echo $stats['repos_player']; ?></h4>
                <p class="mb-0">En repos</p>
            </div>
            <div class="col-md-3">
                <h4><?php echo $stats['avg_performance']; ?>%</h4>
                <p class="mb-0">Performance moyenne</p>
            </div>
        </div>
    </div>
<br>
    <!-- Filtres avancés -->
    <div class="filter-section mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form action="" method="GET" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un joueur..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="btn-group w-100">
                    <a href="?filter=all" class="btn btn-outline-primary <?php echo $filter === 'all' ? 'active' : ''; ?>">Tous</a>
                    <a href="?filter=active" class="btn btn-outline-success <?php echo $filter === 'active' ? 'active' : ''; ?>">Actifs</a>
                    <a href="?filter=blessee" class="btn btn-outline-danger <?php echo $filter === 'blessee' ? 'active' : ''; ?>">Blessés</a>
                    <a href="?filter=repos" class="btn btn-outline-warning <?php echo $filter === 'repos' ? 'active' : ''; ?>">En repos</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <?php if (empty($players_page)): ?>
        <div class="col-12">
            <div class=" text-center alert alert-warning">
                <i class="fas fa-info-circle"></i> Aucun joueur à afficher.
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($players_page as $player): ?>
            <div class="col-md-6 mb-3">
                <div class="card player-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="images/joueurs_<?php echo $player['id']; ?>.jpg"  
                                     alt="<?php echo htmlspecialchars($player['nom']); ?>" 
                                     class="player-img">
                            </div>
                            <div class="col">
                                <h5 class="card-title mb-1 ">
                                    <span class="status-indicator status-<?php echo $player['status']; ?>"></span>
                                     <?php echo strtoupper($player['nom']); ?>
                                    <?php echo getPlayerStatus($player); ?>
                                </h5>
                                <p class="card-text text-muted mb-2"><?php echo htmlspecialchars($player['position']); ?></p>
                                
                                
                                <div class="mt-3">
                                    <div class="stat-label ">Condition physique</div>
                                    <div class="progress">
                                        <div class="progress-bar <?php echo getProgressBarColor($player['physical_condition']); ?>" 
                                             style="width: <?php echo $player['physical_condition']; ?>%">
                                             <?php echo formatPercentage($player['physical_condition']); ?></div>
                                             
                                    </div>

                                    <div class="stat-label mt-2">Performance</div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" 
                                             style="width: <?php echo $player['performance']; ?>%">
                                             <?php echo formatPercentage($player['performance']); ?>
                                            </div>
                                    </div>

                                    <div class="d-flex justify-content-between  mt-3">
                                        
                                        </span>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $player['id']; ?>"><i class="fas fa-edit me-1"></i>Modifier</button>
                                        <a href="detail.php?id=<?php echo $player['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-chart-line me-1"></i>Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Modal de modification -->
             <div class="modal fade" id="editModal<?php echo $player['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $player['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel<?php echo $player['id']; ?>">Modifier les stats de <?php echo strtoupper($player['nom']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="modifier.php" method="POST">
                                <input type="hidden" name="player_id" value="<?php echo $player['id']; ?>">
                                <div class="mb-3">
                                    <label for="status<?php echo $player['id']; ?>" class="form-label">Statut</label>
                                    <select class="form-select" id="status<?php echo $player['id']; ?>" name="status" required>
                                        <option value="active" <?php echo $player['status'] === 'active' ? 'selected' : ''; ?>>Actif</option>
                                        <option value="blessee" <?php echo $player['status'] === 'blessee' ? 'selected' : ''; ?>>Blessé</option>
                                        <option value="repos" <?php echo $player['status'] === 'repos' ? 'selected' : ''; ?>>En repos</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="physical_condition<?php echo $player['id']; ?>" class="form-label">Condition physique (%)</label>
                                    <input type="number" class="form-control" id="physical_condition<?php echo $player['id']; ?>" name="physical_condition" min="0" max="100" value="<?php echo $player['physical_condition']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="performance<?php echo $player['id']; ?>" class="form-label">Performance (%)</label>
                                    <input type="number" class="form-control" id="performance<?php echo $player['id']; ?>" name="performance" min="0" max="100" value="<?php echo $player['performance']; ?>" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>



    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <nav aria-label="Navigation des pages">
        <ul class="pagination justify-content-center">
            <!-- Bouton Précédent -->
            <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>" aria-label="Précédent">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Numéros des pages -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($current_page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Bouton Suivant -->
            <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>" aria-label="Suivant">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<footer class="bg-dark text-white mt-4">
    <div class="container ">
        <div class="row">
            <div class="col-md">
                <p class="text-center">© 2024 Gestion des Joueurs. Tous droits réservés.</p>
            </div>
        
        </div>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka+S/yEKyVQ2AAJSoRaGqH6tnu9Nfi1p19UuF1FjpyuhJlGzE1v6I3Zg9L5bfp6A" crossorigin="anonymous"></script>
</body>
</html>