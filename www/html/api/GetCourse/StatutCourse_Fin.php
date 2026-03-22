<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Vérifie que la méthode est bien PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405); // Méthode non autorisée
    echo json_encode([
        "success" => false,
        "message" => "Méthode non autorisée."
    ]);
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/database.php';
require_once __DIR__ . '/../../dal/CourseDAL.php';

$courseId = isset($_GET['courseId']) ? intval($_GET['courseId']) : 0;

if ($courseId <= 0) {
    echo json_encode(["success" => false, "message" => "courseId manquant ou invalide"]);
    exit;
}

try {
    $courseDAL = new CourseDAL($pdo);

    // Met à jour directement en FINISHED
    $updated = $courseDAL->updateCourseStatus($courseId, 'Finished');

    if ($updated) {
        echo json_encode(["success" => true, "message" => "Course mise à jour en 'Finished'"]);
    } else {
        echo json_encode(["success" => false, "message" => "Échec de la mise à jour"]);
    }

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur",
        "details" => $e->getMessage()
    ]);
}
