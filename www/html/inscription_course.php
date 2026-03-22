<?php

session_start();

$title = "Inscription";
include 'navbar.php';
require 'config/config_mail.php';
include 'config/database.php';
include 'dal/CourseDAL.php';


$courses = new CourseDAL($pdo);
$courses = $courses->getAllOpen();

$old = [];
$errors = [];

if (isset($_SESSION['old'])) {
    $old = $_SESSION['old'];
    unset($_SESSION['old']);
}

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Inscription à la course</h2>

                    <!-- Affichage des erreurs -->
                    <?php if (!empty($errors)) : ?>
                        <?php foreach ($errors as $error) : ?>
                            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <form method="POST" action="confirmation.php">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" id="nom"
                                   value="<?php if (isset($old['nom'])) echo htmlspecialchars($old['nom']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" id="prenom"
                                   value="<?php if (isset($old['prenom'])) echo htmlspecialchars($old['prenom']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="dateNaissance" class="form-label">Date de naissance</label>
                            <input type="date" name="dateNaissance" class="form-control" id="dateNaissance"
                                   value="<?php if (isset($old['dateNaissance'])) echo htmlspecialchars($old['dateNaissance']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" id="adresse"
                                   value="<?php if (isset($old['adresse'])) echo htmlspecialchars($old['adresse']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select class="form-select" name="course" id="course" required>
                                <option disabled <?php if (!isset($old['course'])) echo 'selected'; ?>>Sélectionner la course</option>
                                <?php
                                if ($courses) {
                                    foreach ($courses as $course) {
                                        $selected = '';
                                        if (isset($old['course']) && $old['course'] == $course->idCourses) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="' . $course->idCourses . '" ' . $selected . '>' . htmlspecialchars($course->intitule) . '</option>';
                                    }
                                } else {
                                    echo '<option disabled>Pas de courses disponibles</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                   value="<?php if (isset($old['email'])) echo htmlspecialchars($old['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" id="password"
                                   value="" required>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="autorisation" name="autorisation"
                                   <?php if (isset($old['autorisation'])) echo 'checked'; ?>>
                            <label class="form-check-label" for="autorisation">J'autorise la publication de mes résultats</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Envoyer l'inscription</button>
                        </div>
                    </form>

                    <div class="alert alert-info mt-3" role="alert">
                        Veuillez envoyer votre licence en précisant Inscription course + votre nom et prénom dans l'objet du mail à cette adresse mail afin que votre inscription soit validée :
                        <a href="mailto:courseduchicon.baisieux@gmail.com">courseduchicon.baisieux@gmail.com</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
