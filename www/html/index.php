<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$title = "Accueil";  
include 'navbar.php';

?>
<div class="container text-center my-5">
  
  <!-- Titre principal -->
<!-- TITRE PRINCIPAL -->
<h1 class="display-4 fw-bold text-center" style="color: #1a1a1a;">
  LA COURSE DU CHICON
</h1>
<p class="lead text-center text-muted mb-4">
  L'événement sportif incontournable à Baisieux
</p>


  <!-- Image en bannière -->
  <img class="img-fluid rounded shadow-lg mb-4" 
       src="assets/images/course_chicon.png" 
       alt="Bannière de la Course du Chicon" 
       style="width: 100%; max-width: 800px;">

  <!-- Texte de présentation -->
  <section class="text-start px-lg-5">
    <p class="lead text-muted">
      Depuis plus de 20 ans, l’association <strong>"LA COURSE DU CHICON"</strong> Courir à BAISIEUX réunit aujourd’hui des hommes et des femmes de tout âge qui, un jour, ont entendu parlé, lors de la course du chicon ou sur une autre manifestation,
de l’ambiance chaleureuse qui régnait au sein de notre association. Les objectifs de nos coureurs et marcehrus sont divers.

Certains souhaitent améliorer leurs performances, d’autres viennent aux rendez-vous pour retrouver les amis afin d’oublier le stress de la journée et passer ainsi un
agréable moment tout en faisant du sport.

Quelque soit le temps, ils aiment se retrouver pour chatouiller le bitume ou les chemins de campagne. Nous avons dans notre groupe des adeptes de la course « détente »,
des « accros » du chrono, des « fondus » du grand fond (Marathon, 100 KM,…), des « fans» des courses natures (Trails), des « raideurs de l’extrême» (SaintéLyon, OCC, Traildu St Jacques…).

Beaucoup, chacun à son niveau, aiment participer aux courses régionales, nationales ou internationales. Du dix kilomètres au marathon, en passant pas le semi-marathon,
le quinze kilomètres, chaque compétition est l’occasion de découvrir une ville, un village, une région et des coureurs avec qui nous échangeons nos expériences,
nos tuyaux,…bref beaucoup de plaisir et la joie de partager notre passion avec d’autres.
    </p>
  </section>


<!-- SECTION DES COURSES -->
<div class="row justify-content-center g-4 my-5">

  <!-- Carte Enfants -->
  <div class="col-md-5">
    <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #f0f8ff;">
      <h4 class="fw-semibold text-primary mb-2">Courses Enfants</h4>
      <p class="text-muted mb-0">500 m · 1000 m · 1500 m</p>
    </div>
  </div>

  <!--
  <div class="col-md-5">
    <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #fff8e1;">
      <h4 class="fw-semibold text-warning mb-2">Courses Adultes</h4>
      <p class="text-muted mb-0">5 km · 10 km · 15 km</p>
    </div>
  </div>

</div>
 Carte Adultes -->
 
<!-- BOUTONS -->
<div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
  <a href="inscription_course.php" class="btn btn-success btn-lg rounded-pill px-4">
    S'inscrire
  </a>
  <a href="resultats.php" class="btn btn-outline-primary btn-lg rounded-pill px-4">
    Voir les Résultats
  </a>
</div>


<?php include 'footer.php'; ?>
</body>

</html>

