<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';
require_once '../../dal/CourseDAL.php';

$courseDAL = new CourseDAL($pdo);

// Vérifie que c'est bien une requête PUT
/**if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée. Utilisez PUT."]);
    exit;
}**/

// Récupère les données JSON du body
$data = json_decode(file_get_contents("php://input"), true);

// Vérifie la présence de courseId
if (!isset($data['courseId'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "courseId manquant."]);
    exit;
}

$courseId = intval($data['courseId']);

try {
    $success = $courseDAL->updateStatusChrono($courseId);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Statut mis à jour à 'Chrono'."]);
    } else {
        echo json_encode(["success" => false, "message" => "Aucune course mise à jour. Vérifiez que le statut est bien 'Ready'."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur.",
        "details" => $e->getMessage()
    ]);
}
