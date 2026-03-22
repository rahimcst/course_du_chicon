<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

file_put_contents("log.txt", json_encode($data, JSON_PRETTY_PRINT));

if (!isset($data["intitule"], $data["distance"], $data["date"], $data["dateLimite"])) {
    echo json_encode(["success" => false, "message" => "Données incomplètes"]);
    exit();
}

$intitule = $data["intitule"];
$distance = (int) $data["distance"];
$date = $data["date"];
$dateLimite = $data["dateLimite"];

$sql = "INSERT INTO courses (intitule, distance, date, dateLimite) 
        VALUES (?, ?, ?, ?)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $intitule, PDO::PARAM_STR);
    $stmt->bindParam(2, $distance, PDO::PARAM_INT);
    $stmt->bindParam(3, $date, PDO::PARAM_STR);
    $stmt->bindParam(4, $dateLimite, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Course ajoutée avec succès"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur SQL"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur lors de l'exécution", "details" => $e->getMessage()]);
}
?>