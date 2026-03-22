<?php
session_start();
require 'config/database.php';
require 'dal/ParticipantDAL.php';
require 'dal/InscriptionDAL.php';

$title = "Suppression de compte";
include 'navbar.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$pdo = new MyPDO();
$participantDAL = new ParticipantDAL($pdo);
$inscriptionDAL = new InscriptionDAL($pdo);

$email = $_SESSION['user_email'];
$participant = $participantDAL->getByEmail($email);

// Suppression des inscriptions
$pdo->prepare("DELETE FROM inscriptions WHERE idParticipant = ?")->execute([$participant->idParticipants]);

// Suppression du compte
$participantDAL->deleteById($participant->idParticipants);

// Déconnexion
session_destroy();
?>
<div class="container text-center my-5">
    <h1 class="display-5 fw-bold text-danger">Compte supprimé avec succès</h1>
    <p class="lead text-muted">Merci d’avoir participé à la Course du Chicon.</p>
    <div class="spinner-border text-danger my-4" role="status"></div>
    <br>
    <a href="login.php" class="btn btn-outline-secondary mt-3">Retour à la connexion</a>
</div>

<script>
    setTimeout(() => {
        window.location.href = 'login.php';
    }, 4000);
</script>

<?php include 'footer.php'; ?>
</body>

</html>