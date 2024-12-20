<?php
// include('connecter.php');
class Cours
{
    private $id;
    private $heure; // pour l'heure
    private $matieres; // un tableau pour les matieres de la semaine

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setHeure($heure)
    {
        $this->heure = $heure;
    }

    public function setMatiere($matieres)
    {
        $this->matieres = $matieres;
    }

    // Ajouter une nouvelle ligne
    public function ajouter($heure, $courLundi, $courMardi, $courMercredi, $courJeudi, $courVendredi, $courSamedi)
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projetcentreformation', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('INSERT INTO cours (heure, courLundi, courMardi, courMercredi, courJeudi, courVendredi, courSamedi) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$heure, $courLundi, $courMardi, $courMercredi, $courJeudi, $courVendredi, $courSamedi]);

            echo "Ligne ajoutée avec succès!";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Modifier une ligne
    public function modifier($id, $heure, $courLundi, $courMardi, $courMercredi, $courJeudi, $courVendredi, $courSamedi)
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projetcentreformation', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('UPDATE cours SET heure = ?, courLundi = ?, courMardi = ?, courMercredi = ?, courJeudi = ?, courVendredi = ?, courSamedi = ? WHERE id = ?');
            $stmt->execute([$heure, $courLundi, $courMardi, $courMercredi, $courJeudi, $courVendredi, $courSamedi, $id]);

            echo "Ligne modifiée avec succès!";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Supprimer une ligne
    public function supprimer($id)
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projetcentreformation', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('DELETE FROM cours WHERE id = ?');
            $stmt->execute([$id]);

            echo "Ligne supprimée avec succès!";
        } catch (PDOException $e) { 
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Récupérer toutes les lignes
    public function recupererCours()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=projetcentreformation', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query('SELECT * FROM cours');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Gestion des ajouts et modifications
if (isset($_POST['ajouter'])) {
    $heure = $_POST['heure'];
    $courLundi = $_POST['courLundi'];
    $courMardi = $_POST['courMardi'];
    $courMercredi = $_POST['courMercredi'];
    $courJeudi = $_POST['courJeudi'];
    $courVendredi = $_POST['courVendredi'];
    $courSamedi = $_POST['courSamedi'];

    $cours = new Cours();
    $cours->ajouter($heure, $courLundi, $courMardi, $courMercredi, $courJeudi, $courVendredi, $courSamedi);
}

if (isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $heure = $_POST['heure'];
    $courLundi = $_POST['courLundi'];
    $courMardi = $_POST['courMardi'];
    $courMercredi = $_POST['courMercredi'];
    $courJeudi = $_POST['courJeudi'];
    $courVendredi = $_POST['courVendredi'];
    $courSamedi = $_POST['courSamedi'];

    $cours = new Cours();
    $cours->modifier($id, $heure, $courLundi, $courMardi, $courMercredi, $courJeudi, $courVendredi, $courSamedi);
}

if (isset($_POST['supprimer'])) {
    $id = $_POST['id'];

    $cours = new Cours();
    $cours->supprimer($id);
}

$cours = new Cours();
$emploiDuTemps = $cours->recupererCours();
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <title>Gestion des emplois du temps</title>
    <style>
        .form-check-label {
            transition: color 0.3s, transform 0.3s;
        }

        .form-check-input:checked~.form-check-label {
            color: yellow;
            transform: rotate(360deg);
        }

        input {
            box-shadow: none !important;
            outline: none !important;
        }
    </style>
</head>

<body style="background-image: url('paper.png');">
    <header class="bg-dark fw-bold text-light p-3 mb-5">
        <div class="form-check form-switch m-2 d-flex justify-content-center cursor-pointer">
            <input class="form-check-input me-1" type="checkbox" id="toggleButton">
            <label class="form-check-label" for="toggleButton">Basculer en mode admin</label>
        </div>
    </header>

    <div class="container table-responsive">
        <form method="post">
            <div class="mb-4">
                <button class="btn btn-primary" name="ajouter" type="button" onclick="toggleAddRow()">Ajouter une ligne</button>
            </div>

            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Heure</th>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                        <th>Jeudi</th>
                        <th>Vendredi</th>
                        <th>Samedi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emploiDuTemps as $ligne) : ?>
                        <tr>
                            <td><?= htmlspecialchars($ligne['heure']) ?></td>
                            <td><?= htmlspecialchars($ligne['courLundi']) ?></td>
                            <td><?= htmlspecialchars($ligne['courMardi']) ?></td>
                            <td><?= htmlspecialchars($ligne['courMercredi']) ?></td>
                            <td><?= htmlspecialchars($ligne['courJeudi']) ?></td>
                            <td><?= htmlspecialchars($ligne['courVendredi']) ?></td>
                            <td><?= htmlspecialchars($ligne['courSamedi']) ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" name="modifier" type="button" onclick="populateForm(<?= $ligne['id'] ?>, '<?= htmlspecialchars($ligne['heure']) ?>', '<?= htmlspecialchars($ligne['courLundi']) ?>', '<?= htmlspecialchars($ligne['courMardi']) ?>', '<?= htmlspecialchars($ligne['courMercredi']) ?>', '<?= htmlspecialchars($ligne['courJeudi'])
                            ?>', '<?= htmlspecialchars($ligne['courVendredi']) ?>', '<?= htmlspecialchars($ligne['courSamedi']) ?>')">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" name="supprimer" type="submit" onclick="deleteRow(<?= $ligne['id'] ?>)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Formulaire caché pour ajouter/modifier -->
            <div id="adminForm" class="mt-3" style="display: none;">
                <h5>Formulaire Admin</h5>
                <input type="hidden" id="formId" name="id">
                <div class="mb-2">
                    <label for="heure">Heure :</label>
                    <input type="text" id="heure" name="heure" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="courLundi">Lundi :</label>
                    <input type="text" id="courLundi" name="courLundi" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="courMardi">Mardi :</label>
                    <input type="text" id="courMardi" name="courMardi" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="courMercredi">Mercredi :</label>
                    <input type="text" id="courMercredi" name="courMercredi" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="courJeudi">Jeudi :</label>
                    <input type="text" id="courJeudi" name="courJeudi" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="courVendredi">Vendredi :</label>
                    <input type="text" id="courVendredi" name="courVendredi" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="courSamedi">Samedi :</label>
                    <input type="text" id="courSamedi" name="courSamedi" class="form-control">
                </div>
                <button type="submit" name="ajouter" class="btn btn-success">Enregistrer</button>
            </div>
        </form>
    </div>

    <script>
        let isAdmin = false;

        document.getElementById('toggleButton').addEventListener('change', function () {
            isAdmin = this.checked;
            document.getElementById('adminForm').style.display = isAdmin ? 'block' : 'none';
        });

        function toggleAddRow() {
            if (isAdmin) {
                document.getElementById('formId').value = '';
                document.getElementById('heure').value = '';
                document.getElementById('courLundi').value = '';
                document.getElementById('courMardi').value = '';
                document.getElementById('courMercredi').value = '';
                document.getElementById('courJeudi').value = '';
                document.getElementById('courVendredi').value = '';
                document.getElementById('courSamedi').value = '';
            } else {
                alert('Veuillez activer le mode admin pour ajouter une ligne.');
            }
        }

        function populateForm(id, heure, lundi, mardi, mercredi, jeudi, vendredi, samedi) {
            if (isAdmin) {
                document.getElementById('formId').value = id;
                document.getElementById('heure').value = heure;
                document.getElementById('courLundi').value = lundi;
                document.getElementById('courMardi').value = mardi;
                document.getElementById('courMercredi').value = mercredi;
                document.getElementById('courJeudi').value = jeudi;
                document.getElementById('courVendredi').value = vendredi;
                document.getElementById('courSamedi').value = samedi;
            } else {
                alert('Veuillez activer le mode admin pour modifier une ligne.');
            }
        }

        function deleteRow(id) {
            if (!isAdmin) {
                alert('Veuillez activer le mode admin pour supprimer une ligne.');
                return false;
            }
            const confirmDelete = confirm('Êtes-vous sûr de vouloir supprimer cette ligne ?');
            if (confirmDelete) {
                const form = document.createElement('form');
                form.method = 'post';
                form.style.display = 'none';

                const input = document.createElement('input');
                input.name = 'id';
                input.value = id;
                form.appendChild(input);

                const deleteInput = document.createElement('input');
                deleteInput.name = 'supprimer';
                form.appendChild(deleteInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
