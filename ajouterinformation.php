<?php
require_once "conn.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$coachId = $_SESSION['user_id'];

// Ajout d'un diplôme
if (isset($_POST['diplome_titre']) && isset($_POST['diplome_annee'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO diplomes (titre, annee, entraineur_id) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['diplome_titre'],
            $_POST['diplome_annee'],
            $coachId
        ]);
        header('Location: entraineur.php?success=diplome');
        exit();
    } catch(PDOException $e) {
        header('Location: entraineur.php?error=diplome');
        exit();
    }
}

// Ajout d'une spécialisation
if (isset($_POST['specialisation_nom']) && isset($_POST['specialisation_niveau'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO specialisations (nom, progression, entraineur_id) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['specialisation_nom'],
            $_POST['specialisation_niveau'],
            $coachId
        ]);
        header('Location: entraineur.php?success=specialisation');
        exit();
    } catch(PDOException $e) {
        header('Location: entraineur.php?error=specialisation');
        exit();
    }
}

// Ajout d'une carrière
if (isset($_POST['carriere_club']) && isset($_POST['carriere_description'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO carreires (club, description, id_entraineur) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['carriere_club'],
            $_POST['carriere_description'],
            $coachId
        ]);
        header('Location: entraineur.php?success=carriere');
        exit();
    } catch(PDOException $e) {
        header('Location: entraineur.php?error=carriere');
        exit();
    }
}

// Si aucune action n'est effectuée, rediriger vers le tableau de bord
header('Location: entraineur.php');
exit();
?>