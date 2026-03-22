<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config/database.php';
require 'models/Participant.php';
require 'dal/ParticipantDAL.php';
require 'config/config.php';
$title = "Réinitialiser le mot de passe";
include 'navbar.php';
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body">

          <?php
          if (isset($_GET['token'])) {
            $token = urldecode($_GET['token']);

            if (!isset($_SESSION['secret_key'])) {
              echo "<div class='alert alert-danger'>Erreur. Veuillez recommencer le processus.</div>";
              exit;
            }

            $secretKey = $_SESSION['secret_key'];
            $decodedToken = base64_decode($token);
            $parts = explode('|', $decodedToken);

            if (count($parts) == 3) {
              list($email, $timestamp, $hmac) = $parts;

              if ((time() - (int) $timestamp) > TOKEN_EXPIRATION) {
                echo "<div class='alert alert-danger'>Le lien a expiré.</div>";
              } else {
                $data = $email . '|' . $timestamp;
                $computedHmac = hash_hmac('sha256', $data, $secretKey);

                if (hash_equals($hmac, $computedHmac)) {
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $newPassword = $_POST['password'];
                    $pdo = new MyPDO();
                    $participantDAL = new ParticipantDAL($pdo);
                    $participant = $participantDAL->getByEmail($email);

                    if ($participant) {
                      $participantDAL->updatePassword($email, $newPassword);
                      echo "<div class='alert alert-success'>Mot de passe mis à jour avec succès.</div>";
                    } else {
                      echo "<div class='alert alert-danger'>Utilisateur non trouvé.</div>";
                    }
                  } else {
                    ?>

                    <h4 class="text-center mb-4">Réinitialiser le mot de passe</h4>
                    <form method="POST">
                      <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                      </div>
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Valider</button>
                      </div>
                    </form>

                    <?php
                  }
                } else {
                  echo "<div class='alert alert-danger'>Lien invalide.</div>";
                }
              }
            } else {
              echo "<div class='alert alert-danger'>Lien invalide.</div>";
            }
          } else {
            echo "<div class='alert alert-danger'>Token manquant.</div>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>