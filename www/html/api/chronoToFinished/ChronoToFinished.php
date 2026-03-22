<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';
require_once '../../dal/CourseDAL.php';

$courseDAL = new CourseDAL($pdo);


$data = json_decode(file_get_contents("php://input"), true);

// Vérifie la présence de courseId
if (!isset($data['courseId'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "courseId manquant."]);
    exit;
}

$courseId = intval($data['courseId']);


try {
    $success = $courseDAL->updateStatusFinished($courseId);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Statut mis à jour à 'Finished'."]);
    } else {
        echo json_encode(["success" => false, "message" => "Aucune course mise à jour. Vérifiez que le statut est bien 'Chrono'."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur.",
        "details" => $e->getMessage()
    ]);
}
