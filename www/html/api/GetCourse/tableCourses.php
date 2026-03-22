<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require __DIR__ . '/../../config/database.php'; // Correction de la concaténation
require_once __DIR__ . '/../../dal/CourseDAL.php'; // Correction de la concaténation

// Créer une instance de CourseDAL avec la connexion PDO
$course = new CourseDAL($pdo);

// Récupérer toutes les courses
$result = $course->getAll();

// Vérifier si la récupération des données a échoué
if (!$result) {
    error_log("SQL error: " . $pdo->errorInfo()); // Log l'erreur SQL
    echo json_encode(["error" => "Error executing query: " . $pdo->errorInfo()]);
    exit; 
}

// Si des résultats sont trouvés
if (count($result) > 0) {
    // Envoyer les données en format JSON
    echo json_encode($result);
} else {
    // Si aucune course n'est trouvée
    echo json_encode([]);
}

// Fermer la connexion PDO
$pdo = null;
?>
