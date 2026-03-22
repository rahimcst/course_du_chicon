<?php
session_start();

// Définir le titre par défaut de la page
// Par défaut, c'est "Accueil", tu pourras le changer selon la page

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./assets/css/bootstrap.css" rel="stylesheet" />
  <title><?php echo htmlspecialchars($title); ?></title>
</head>

<body>

  <script type="text/javascript" src="assets/js/bootstrap.bundle.js"></script>
  <script type="text/javascript" src="assets/js/validateForm.js"></script>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand" href="#"><img style="width: 70px; height:auto;" class="img-fluid img-responsive"
          src="assets/images/logo.png" alt=""></a>

      <!-- Toggler button for mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar items -->
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <!-- Centered items: logo + Accueil + Inscription -->
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="inscription_course.php">Inscription</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="contact.php">Nous contacter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="reglement.php">Règlement</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="rgpd.php">RGPD</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="parcours.php">Les parcours</a>
          </li>
          <?php
          // Afficher l'option "S'inscrire à une nouvelle course" si l'utilisateur est connecté
          if (isset($_SESSION['user_email'])) {
            echo '
            <li class="nav-item">
              <a class="nav-link" href="inscription_course.php">S\'inscrire à une nouvelle course</a>
            </li>';
          }
          ?>

          <li class="nav-item">
            <a class="nav-link" href="resultats.php">Résultats</a>
          </li>
        </ul>

        <?php
        // Si l'utilisateur est connecté
        if (isset($_SESSION['user_prenom']) && isset($_SESSION[('user_nom')])) {
          echo '
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="profile.php">Bienvenue, ' . htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']) . '</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Déconnexion</a>
            </li>
          </ul>';
        } else {
          // Si l'utilisateur n'est pas connecté
          echo '
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="login.php">Se connecter</a>
            </li>
          </ul>';
        }
        ?>

      </div>
    </div>
  </nav>

</body>

</html>