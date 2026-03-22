<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';  // Inclure le fichier de connexion

// Détecter la donnée entre JSON, POST ou GET :
$data = json_decode(file_get_contents("php://input"), true);

$idInscriptions = null;
$dossard = null;

if (is_array($data) && isset($data['idInscriptions']) && isset($data['dossard'])) {
    $idInscriptions = (int) $data['idInscriptions'];
    $dossard = (int) $data['dossard'];
} elseif (isset($_POST["idInscriptions"]) && isset($_POST["dossard"])) {
    $idInscriptions = (int) $_POST["idInscriptions"];
    $dossard = (int) $_POST["dossard"];
} elseif (isset($_GET["idInscriptions"]) && isset($_GET["dossard"])) {
    $idInscriptions = (int) $_GET["idInscriptions"];
    $dossard = (int) $_GET["dossard"];
}

if (!is_null($idInscriptions) && !is_null($dossard)) {

    // Vérifier si le dossard existe déjà
    $query = "SELECT * FROM inscriptions WHERE numeroDossard = ?";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $dossard, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => false, "message" => "Le dossard existe déjà"]);
        } else {
            // Mettre à jour le dossard
            $updateQuery = "UPDATE inscriptions SET numeroDossard = ? WHERE idInscriptions = ?";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(1, $dossard, PDO::PARAM_INT);
            $updateStmt->bindParam(2, $idInscriptions, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                echo json_encode(["success" => true, "message" => "Dossard mis à jour"]);
            } else {
                echo json_encode(["success" => false, "message" => "Erreur SQL : " . json_encode($updateStmt->errorInfo())]);
            }
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur de préparation ou d'exécution de la requête", "details" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Données incomplètes"]);
}
?>