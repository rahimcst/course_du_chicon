<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, GET, OPTIONS"); // Autorise GET et PUT
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';

// Récupérer les données depuis le JSON ou les paramètres GET
$data = json_decode(file_get_contents("php://input"), true);

// Priorité au JSON, sinon on cherche dans GET
if (empty($data)) {
    $data = $_GET;
}

if (isset($data['idInscription']) && isset($data['licence'])) {
    $idInscription = intval($data['idInscription']);
    $licence = $data['licence'];

    $query = "UPDATE participants p
              INNER JOIN inscriptions i ON p.idParticipants = i.idParticipant
              SET p.licence = ?
              WHERE i.idInscriptions = ?";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $licence, PDO::PARAM_STR);
        $stmt->bindParam(2, $idInscription, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Licence mise à jour"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur d'exécution", "details" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Données manquantes"]);
}
?>