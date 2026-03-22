<?php
session_start();
require 'config/database.php';
require 'dal/ParticipantDAL.php';
require 'dal/InscriptionDAL.php';
require 'dal/CourseDAL.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$pdo = new MyPDO();
$participantDAL = new ParticipantDAL($pdo);
$inscriptionDAL = new InscriptionDAL($pdo);
$courseDAL = new CourseDAL($pdo);

$email = $_SESSION['user_email'];
$participant = $participantDAL->getByEmail($email);
$courses = $inscriptionDAL->getCoursesByParticipantId($participant->idParticipants);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center mb-4">Mon Profil</h2>
                    <hr>

                    <!-- Infos utilisateur -->
                    <h4>Informations personnelles</h4>
                    <p><strong>Nom :</strong> <?= htmlspecialchars($participant->nom); ?></p>
                    <p><strong>Prénom :</strong> <?= htmlspecialchars($participant->prenom); ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($participant->mail); ?></p>
                    <p><strong>Date de naissance :</strong> <?= htmlspecialchars($participant->date_naissance); ?></p>
                    <hr>

                    <!-- Inscriptions -->
                    <h4>Mes inscriptions aux courses</h4>

                    <?php if (!empty($courses)): ?>
                        <ul class="list-group">
                            <?php foreach ($courses as $course): ?>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                                        <div class="me-3">
                                            <p><strong>Course :</strong> <?= htmlspecialchars($course['intitule']) ?>
                                                <strong>Distance :</strong> <?= htmlspecialchars($course['distance']) ?> m
                                                <strong>Date :</strong> <?= htmlspecialchars($course['date']) ?>
                                            </p>
                                            <p><strong>Statut :</strong>
                                                <?php if ($course['statut_inscription'] == 'En attente'): ?>
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                <?php elseif ($course['statut_inscription'] == 'Approuvée'): ?>
                                                    <span class="badge bg-success">Approuvée</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Non inscrit</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="mt-2">
                                            <a href="annuler_inscription.php?course_id=<?= $course['idCourses'] ?>"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette inscription ?');">
                                                Annuler l'inscription
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Aucune inscription trouvée.</p>
                    <?php endif; ?>

                    <hr>

                    <!-- Boutons actions -->
                    <div class="d-flex justify-content-between">
                        <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
                        <a href="supprimer_compte.php" class="btn btn-outline-danger"
                            onclick="return confirm('Cette action supprimera votre compte et toutes vos inscriptions. Êtes-vous sûr ?');">
                            Supprimer mon compte
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>