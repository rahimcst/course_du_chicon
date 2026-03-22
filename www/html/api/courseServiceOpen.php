<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

try {
    require_once(__DIR__ . '/../config/database.php');
    require_once(__DIR__ . '/../dal/CourseDAL.php');
    
    // Créez une instance de CourseDAL
    $courseDAL = new CourseDAL($pdo);
    
    // Récupérez les cours dont l'inscription est ouverte
    $courses = $courseDAL->getAllOpen();
    
    // Encodez les données des cours en JSON et renvoyez-les
    echo json_encode($courses);

} catch (Exception $e) {
    // En cas d'erreur, renvoyer un code 500 avec le message d'erreur
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
