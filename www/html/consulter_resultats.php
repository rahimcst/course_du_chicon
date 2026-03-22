<?php
require_once 'config/database.php';
require_once 'dal/InscriptionDAL.php';
require_once 'dal/CourseDAL.php';

$courseId = isset($_GET['id']) ? $_GET['id'] : 0;

if ($courseId <= 0) {
    echo "Course invalide.";
    exit;
}

$courseDAL = new CourseDAL($pdo);
$inscriptionDAL = new InscriptionDAL($pdo);

// Récupérer la course
$course = $courseDAL->getById($courseId);
if (!$course) {
    echo "Course non trouvée.";
    exit;
}

$resultats = $inscriptionDAL->getAllParticipantsWithAutorisation($courseId);

// Trie par chrono croissant (en ignorant ceux avec chrono null pour les mettre en fin)
usort($resultats, function ($a, $b) {
    if (!$a['chrono'])
        return 1;
    if (!$b['chrono'])
        return -1;
    return strtotime($a['chrono']) - strtotime($b['chrono']);
});

// ------------------------------------------
?>
<?php
$title = "Résultats de la course";
include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Résultats de la Course</h1>
        <h2 class="text-center"><?= htmlspecialchars($course->intitule) ?></h2>
        <?php if (empty($resultats)): ?>
            <p class="text-center">Aucun participant inscrit à cette course.</p>
        <?php else: ?>
            <table class="table table-bordered bg-blue table-hover shadow">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">Rang</th>
                        <th class="text-center">Numéro du Dossard</th>
                        <th class="text-center">Nom</th>
                        <th class="text-center">Prénom</th>
                        <th class="text-center">Chrono</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <?php $rank = 1; ?>
                    <?php foreach ($resultats as $resultat): ?>
                        <?php if (isset($resultat['autorisation']) && $resultat['autorisation'] == 1): ?>
                            <tr>
                                <td class="text-center"><?= $rank ?></td>
                                <td class="text-center"><?= htmlspecialchars($resultat['numeroDossard']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($resultat['nom']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($resultat['prenom']) ?></td>
                                <td class="text-center">
                                    <?php
                                    if ($resultat['chrono'] != NULL) {
                                        echo htmlspecialchars($resultat['chrono']);
                                    } elseif ($course->statut === 'Finished') {
                                        echo "<span class='text-danger'>Non classé</span>";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td class="text-center"><?= $rank ?></td>
                                <td class="text-center"><?= htmlspecialchars($resultat['numeroDossard']) ?></td>
                                <td class="text-center">XXXXX</td>
                                <td class="text-center">XXXXX</td>
                                <td><?= htmlspecialchars($resultat['chrono']) ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php $rank++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a href="resultats.php" class="btn btn-primary mb-4">
            ← Retour à la liste des courses
        </a>
    </div>


    <?php include 'footer.php' ?>
</body>

</html>