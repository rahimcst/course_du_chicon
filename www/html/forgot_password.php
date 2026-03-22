<?php
/**ini_set('display_errors', 1);
error_reporting(E_ALL);**/

$title = "Mot de passe oublié";

// Inclusion des fichiers nécessaires
require 'config/database.php';
require 'models/Participant.php';
require 'dal/ParticipantDAL.php';
require 'models/Mail.php';
require 'config/config.php';

include 'navbar.php';
session_start(); // Démarrer la session

// Générer une clé secrète aléatoire
$secretKey = bin2hex(random_bytes(32));
$_SESSION['secret_key'] = $secretKey; // Stocker la clé dans la session

define('TOKEN_EXPIRATION', 900); // 15 minutes d'expiration

// Message de retour
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Connexion à la base de données et récupération de l'utilisateur
    $pdo = new MyPDO();
    $participantDAL = new ParticipantDAL($pdo);
    $participant = $participantDAL->getByEmail($email);

    if ($participant) {
        // Créer un token sécurisé
        $timestamp = time();
        $data = $email . '|' . $timestamp;
        $hmac = hash_hmac('sha256', $data, $secretKey); // Utiliser la clé générée
        $token = base64_encode($data . '|' . $hmac);

        // Créer un lien de réinitialisation
        $resetLink = "http://172.16.245.15/reset_password.php?token=" . urlencode($token);

        // Utiliser la classe Mail pour envoyer l'email
        $mail = new Mail("Réinitialisation de votre mot de passe");
        $subject = "Réinitialisation de votre mot de passe";
        $messageBody = "Cliquez sur ce lien pour réinitialiser votre mot de passe : <a href='" . $resetLink . "'>Réinitialiser mon mot de passe</a>";

        // Envoi de l'email
        $mailResult = $mail->envoyerMail($email, $subject, $messageBody);

        if ($mailResult === true) {
            $message = "<div class='alert alert-success text-center'>Un email de réinitialisation a été envoyé à votre adresse.</div>";
        } else {
            $message = "<div class='alert alert-danger text-center'>Erreur lors de l'envoi de l'email : " . $mailResult . "</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>Cet email n'est pas enregistré.</div>";
    }
}
?>

<body class="bg-light">
    <!-- Wrapper qui prend toute la hauteur -->
    <div class="d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>Réinitialiser votre mot de passe</h4>
                        </div>
                        <div class="card-body">

                            <!-- Affichage des messages -->
                            <?php if ($message): ?>
                                <?php echo $message; ?>
                            <?php endif; ?>

                            <!-- Formulaire -->
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Envoyer le lien de réinitialisation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<?php include 'footer.php' ?>
    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>