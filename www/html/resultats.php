<?php
require 'config/database.php';
require 'dal/CourseDAL.php';

$pdo = new MyPDO();
$courseDAL = new CourseDAL($pdo);

// Récupère toutes les courses terminées
$allCourses = $courseDAL->resultatCourse();

// Récupère la course sélectionnée via GET (s'il y en a une)
$selectedCourseId = $_GET['course'] ?? null;

// Filtre si une course est sélectionnée
$coursesToShow = $selectedCourseId
    ? array_filter($allCourses, fn($course) => $course['idCourses'] == $selectedCourseId)
    : $allCourses;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Résultats des Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php 
    $title = "Résultats";
    include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center mb-4">Résultats des Courses</h2>

                    <!-- Formulaire de filtre -->
                    <form method="get" class="mb-4">
                        <label for="course" class="form-label">Filtrer par course :</label>
                        <div class="input-group">
                            <select name="course" id="course" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Toutes les courses --</option>
                                <?php foreach ($allCourses as $course): ?>
                                    <option value="<?= $course['idCourses'] ?>" <?= $selectedCourseId == $course['idCourses'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($course['intitule']) ?>
                                        (<?= date('d/m/Y', strtotime($course['date'])) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-outline-secondary">Filtrer</button>
                        </div>
                    </form>

                    <hr>

                    <!-- Liste des résultats -->
                    <?php if (!empty($coursesToShow)): ?>
                        <ul class="list-group">
                            <?php foreach ($coursesToShow as $course): ?>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <p class="mb-1"><strong>Course :</strong>
                                                <?= htmlspecialchars($course['intitule']) ?></p>
                                            <p class="mb-1"><strong>Distance :</strong>
                                                <?= htmlspecialchars($course['distance']) ?> m</p>
                                            <p class="mb-1"><strong>Date :</strong>
                                                <?= date('d/m/Y', strtotime($course['date'])) ?></p>
                                        </div>
                                        <a href="consulter_resultats.php?id=<?= $course['idCourses'] ?>"
                                            class="btn btn-primary">
                                            Consulter
                                        </a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Aucune course trouvée pour ce filtre.</p>
                    <?php endif; ?>

                    <div class="mt-4 text-end">
                        <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>