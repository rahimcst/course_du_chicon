<?php
session_start();
require 'config/database.php';
require 'dal/InscriptionDAL.php';
require 'dal/ParticipantDAL.php';

$title = "Annulation d'inscription";
include 'navbar.php';

if (!isset($_SESSION['user_email']) || !isset($_GET['course_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = new MyPDO();
$inscriptionDAL = new InscriptionDAL($pdo);
$participantDAL = new ParticipantDAL($pdo);

// Récupération des données utilisateur
$participant = $participantDAL->getByEmail($_SESSION['user_email']);
$participantId = $participant->idParticipants;
$courseId = intval($_GET['course_id']);

// Suppression de l'inscription
$inscriptionDAL->deleteByParticipantAndCourse($participantId, $courseId);
?>

<div class="container text-center my-5">
    <h1 class="display-5 fw-bold text-success">Inscription annulée avec succès</h1>
    <p class="lead text-muted">Vous allez être redirigé automatiquement vers votre profil.</p>
    <div class="spinner-border text-success my-4" role="status"></div>
    <br>
    <a href="profile.php" class="btn btn-outline-primary mt-3">Retour immédiat au profil</a>
</div>

<script>
    setTimeout(() => {
        window.location.href = 'profile.php';
    }, 4000);
</script>

<?php include 'footer.php'; ?>
</body>

</html>