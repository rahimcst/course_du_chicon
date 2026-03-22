<?php
// Démarrer la session
session_start();

// Détruire toutes les variables de session
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session

// Rediriger vers la page d'accueil ou la page de connexion
header('Location: index.php'); // Redirection vers la page d'accueil ou login.php selon tes préférences
exit(); // Arrêter l'exécution du script après la redirection
?>
