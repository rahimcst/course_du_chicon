<?php
include 'navbar.php';

// Inclure le fichier de configuration de la base de données (database.php)
require 'config/database.php';  // Assurez-vous que le chemin est correct

// Inclure les classes nécessaires
require 'dal/ParticipantDAL.php';


// Vérifier si un token a été passé dans l'URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        // Créer une instance de PDO à partir de la classe MyPDO (définie dans database.php)
        $pdo = new MyPDO();

        // Créer une instance de la classe DAL
        $participantDAL = new ParticipantDAL($pdo);

        // Vérifier si un utilisateur avec ce token existe
        $participant = $participantDAL->getByToken($token);

        // Définir le message d'activation
        if ($participant) {
            // Activer le compte
            $participantDAL->activerCompte($participant->mail);
            $message = "Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.";
            $alert_class = "alert-success";
        } else {
            $message = "Token invalide ou expiré.";
            $alert_class = "alert-danger";
        }
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
} else {
    $message = "Aucun token de confirmation trouvé.";
    $alert_class = "alert-warning";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation de votre compte</title>
    <!-- Inclure Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Affichage des messages avec Bootstrap -->
                <div class="alert <?php echo $alert_class; ?> text-center" role="alert">
                    <h4 class="alert-heading">Confirmation d'activation</h4>
                    <p><?php echo htmlspecialchars($message); ?></p>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <a href="../index.php" class="btn btn-primary me-3">Retour à l'accueil</a>
                        <a href="../login.php" class="btn btn-success">Se connecter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optionnel : Ajouter le script Bootstrap si nécessaire -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
