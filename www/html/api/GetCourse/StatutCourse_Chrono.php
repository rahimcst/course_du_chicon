<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/database.php';
require_once '../../dal/InscriptionDAL.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['tagRFID']) || !isset($data['chrono'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Données incomplètes : tagRFID et chrono requis."]);
    exit;
}

$tagRFID = $data['tagRFID'];
$chrono = $data['chrono'];

$dal = new InscriptionDAL($pdo);
$success = $dal->mettreAJourChrono($tagRFID, $chrono);

if ($success) {
    echo json_encode(["success" => true, "message" => "Chrono mis à jour avec succès."]);
} else {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "Aucune inscription trouvée avec ce tagRFID pour une course en cours."]);
}
