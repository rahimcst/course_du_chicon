<?php

session_start();

require 'models/Mail.php';
require 'config/config_mail.php';
require 'config/database.php';
require 'models/Participant.php';
require 'dal/ParticipantDAL.php';
require 'dal/InscriptionDAL.php';

$pdo = new MyPDO();
$participantDAL = new ParticipantDAL($pdo);
$inscriptionDAL = new InscriptionDAL($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    // Validation des champs
    if (isset($_POST['nom']) && trim($_POST['nom']) !== '') {
        $nom = trim($_POST['nom']);
    } else {
        $errors[] = "Le nom est obligatoire.";
    }

    if (isset($_POST['prenom']) && trim($_POST['prenom']) !== '') {
        $prenom = trim($_POST['prenom']);
    } else {
        $errors[] = "Le prénom est obligatoire.";
    }

    if (isset($_POST['dateNaissance']) && trim($_POST['dateNaissance']) !== '') {
        $date_naissance = trim($_POST['dateNaissance']);
    } else {
        $errors[] = "La date de naissance est obligatoire.";
    }

    if (isset($_POST['adresse']) && trim($_POST['adresse']) !== '') {
        $adresse = trim($_POST['adresse']);
    } else {
        $errors[] = "L'adresse est obligatoire.";
    }

    if (isset($_POST['course']) && trim($_POST['course']) !== '') {
        $idCourse = (int) trim($_POST['course']);
    } else {
        $errors[] = "La course est obligatoire.";
    }

    if (isset($_POST['email']) && trim($_POST['email']) !== '') {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'email n'est pas valide.";
        } elseif ($participantDAL->checkEmailExists($email)) {
            $errors[] = "Cet email est déjà utilisé.";
        }
    } else {
        $errors[] = "L'email est obligatoire.";
    }
    if (isset($_POST['password']) && trim($_POST['password']) !== '') {
        $password = trim($_POST['password']);
        if (strlen($password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif (!preg_match("/\d/", $password)) {
            $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
        } elseif (!preg_match("/[@$!%*?&]/", $password)) {
            $errors[] = "Le mot de passe doit contenir au moins un caractère spécial (@$!%*?&).";
        }
    } else {
        $errors[] = "Le mot de passe est obligatoire.";
    }

    // Si des erreurs, les afficher et conserver les anciennes données
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: inscription_course.php");
        exit();
    } else {
        $autorisation = isset($_POST['autorisation']) ? 1 : 0;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $token_confirmation = bin2hex(random_bytes(16));

        $participant = new Participant();
        $participant->nom = $nom;
        $participant->prenom = $prenom;
        $participant->date_naissance = $date_naissance;
        $participant->mail = $email;
        $participant->autorisation = $autorisation;
        $participant->password = $hashedPassword;
        $participant->adresse = $adresse;
        $participant->token_confirmation = $token_confirmation;

        try {
            // Insérer dans la base de données
            $participantDAL->insert($participant);
            $idParticipant = $participantDAL->getIdByEmail($email);

            if (!$idParticipant) {
                $_SESSION['errors'] = ["Erreur lors de la récupération de l'ID du participant."];
            } else {
                $participantDAL->updateTokenConfirmation($email, $token_confirmation);

                $inscription = new Inscription();
                $inscription->chrono = null;
                $inscription->tagRFID = null;
                $inscription->numeroDossard = null;
                $inscription->idParticipant = $idParticipant;
                $inscription->idCourse = $idCourse;
                $inscription->statut_inscription = 'En attente';
                $inscriptionDAL->insert($inscription);

                $mail = new Mail();
                $sujet = "Confirmez votre inscription";
                $message = "Bonjour $nom,<br><br>Merci pour votre inscription. Pour activer votre compte, cliquez sur le lien suivant :<br><a href='http://172.16.245.15/activer.php?token=$token_confirmation'>Activer mon compte</a><br><br>Cordialement,<br>L'équipe.";

                $mail->envoyerMail($email, $sujet, $message);

                $_SESSION['confirmation_message'] = "Un email vous a été envoyé pour confirmer votre compte.";
            }
        } catch (PDOException $e) {
            $_SESSION['errors'] = ["Une erreur technique est survenue. Veuillez réessayer plus tard."];
        }
    }
}

?>
<?php
$title = "Confirmation d'inscription";
include 'navbar.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm p-4 text-center">
                <?php if (isset($_SESSION['confirmation_message'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['confirmation_message']; ?>
                    </div>
                    <?php unset($_SESSION['confirmation_message']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php
                        foreach ($_SESSION['errors'] as $error) {
                            echo "<p>$error</p>";
                        }
                        ?>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                <h4 class="mb-3">Inscription réussie</h4>
                <p class="lead">Un email vous a été envoyé pour confirmer votre compte.</p>
                <a href="../index.php" class="btn btn-outline-primary mt-3">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>