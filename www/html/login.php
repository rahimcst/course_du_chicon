<?php
session_start();


// Dépendances
require 'config/database.php';
require 'models/Participant.php';
require 'dal/ParticipantDAL.php';
$title = "Connexion";
include 'navbar.php';

$message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if (!$email || !$password) {
    $message = 'Tous les champs sont obligatoires.';
  } else {
    try {
      $pdo = new MyPDO();
      $participantDAL = new ParticipantDAL($pdo);
      $participant = $participantDAL->getByEmail($email);

      if ($participant) {
        if ($participant->compte_actif != 1) {
          $message = "Votre compte n'est pas activé.";
        } elseif (password_verify($password, $participant->password)) {
          $_SESSION['user_id'] = $participant->idParticipants;
          $_SESSION['user_email'] = $participant->mail;
          $_SESSION['user_prenom'] = $participant->prenom;
          $_SESSION['user_nom'] = $participant->nom;

          header('Location: profile.php');
          exit;
        } else {
          $message = 'Mot de passe incorrect.';
        }
      } else {
        $message = "Aucun compte trouvé avec cet e-mail.";
      }
    } catch (PDOException $e) {
      $message = 'Erreur interne, veuillez réessayer.';
    }
  }
}
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="text-center mb-4">Connexion</h2>

          <?php if ($message): ?>
            <div class="alert alert-danger text-center"><?php echo $message; ?></div>
          <?php endif; ?>

          <form action="login.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
            <div class="text-center mt-3">
              <a href="forgot_password.php">Mot de passe oublié ?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>