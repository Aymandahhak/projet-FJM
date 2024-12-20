<?php
require_once 'conn.php';
require_once 'joueurs.php';

session_start();

// Vérifier si l'ID du joueur est présent
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: suiviejoueurs.php');
    exit();
}

$player_id = intval($_GET['id']);

// Récupérer les détails du joueur
$player = getPlayerById($player_id);

// Si le joueur n'existe pas, rediriger
if (!$player) {
    header('Location: suiviejoueurs.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Joueur</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<div class="container mt-5">
    <h1>Détails du Joueur</h1>
    <a href="suiviejoueurs.php" class="btn btn-light mb-3">
        <i class="fas fa-arrow-left me-2"></i>Retour à la liste des joueurs
    </a>

    <!-- Player Details Card -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="images/player_<?php echo $player['id']; ?>.jpg" 
                         onerror="this.src='https://via.placeholder.com/200'" 
                         alt="Image de <?php echo htmlspecialchars($player['nom']); ?>" 
                         class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h2><?php echo htmlspecialchars($player['nom']); ?></h2>
                    <p><strong>Position:</strong> <?php echo htmlspecialchars($player['position']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($player['status']); ?></p>
                    
                    <h4>Statistiques</h4>
                    <p><strong>Performance:</strong> <?php echo $player['performance']; ?>%</p>
                    <p><strong>Condition Physique:</strong> <?php echo $player['physical_condition']; ?>%</p>
                    
                    <!-- Display weekly performance trend -->
                    <!-- <p>
                        <strong>Tendance Hebdomadaire:</strong>
                        <?php
                        if ($player['weekly_performance_change'] > 0) {
                            echo '<span class="text-success"><i class="fas fa-arrow-up"></i> +' . abs($player['weekly_performance_change']) . '% cette semaine</span>';
                        } elseif ($player['weekly_performance_change'] < 0) {
                            echo '<span class="text-danger"><i class="fas fa-arrow-down"></i> -' . abs($player['weekly_performance_change']) . '% cette semaine</span>';
                        } else {
                            echo '<span class="text-muted"><i class="fas fa-equals"></i> Stable</span>';
                        }
                        ?>
                    </p> -->
                    
                    <!-- Additional Details -->
                    <p><strong>Équipe:</strong> <?php echo htmlspecialchars($player['team']); ?></p>
                    <p><strong>Âge:</strong> <?php echo htmlspecialchars($player['age']); ?> ans</p>
                    <p><strong>Nombre de matchs joués:</strong> <?php echo htmlspecialchars($player['matches_played']); ?></p>
                    <p><strong>Buts marqués:</strong> <?php echo htmlspecialchars($player['goals']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>