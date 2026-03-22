<?php
require_once '../../config/database.php';
require_once '../../dal/InscriptionDAL.php';

header('Content-Type: application/json');


$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(["message" => "JSON invalide"]);
    exit;
}

if (!isset($data['tagRFID']) || !isset($data['chrono'])) {
    http_response_code(400);
    echo json_encode(["message" => "Données incomplètes"]);
    exit;
}

$tagRFID = $data['tagRFID'];
$chrono = $data['chrono'];

try {
    $dal = new InscriptionDAL($pdo);
    $success = $dal->mettreAJourChrono($tagRFID, $chrono);

    if ($success) {
        echo json_encode(["message" => "Chrono mis à jour"]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Erreur lors de la mise à jour"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Exception : " . $e->getMessage()]);
}
