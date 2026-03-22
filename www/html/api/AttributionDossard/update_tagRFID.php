<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';  // Inclure le fichier de connexion

// Récupérer les données depuis JSON, POST ou GET
$data = json_decode(file_get_contents("php://input"), true);

$idInscriptions = null;
$tagRFID = null;

if (is_array($data) && isset($data['idInscriptions']) && isset($data['tagRFID'])) {
    $idInscriptions = intval($data['idInscriptions']);
    $tagRFID = $data['tagRFID'];
} elseif (isset($_POST['idInscriptions']) && isset($_POST['tagRFID'])) {
    $idInscriptions = intval($_POST['idInscriptions']);
    $tagRFID = $_POST['tagRFID'];
} elseif (isset($_GET['idInscriptions']) && isset($_GET['tagRFID'])) {
    $idInscriptions = intval($_GET['idInscriptions']);
    $tagRFID = $_GET['tagRFID'];
}

if (!is_null($idInscriptions) && !is_null($tagRFID)) {
    // Préparer la requête pour mettre à jour le tag RFID
    $query = "UPDATE inscriptions SET tagRFID = ? WHERE idInscriptions = ?";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $tagRFID, PDO::PARAM_STR);
        $stmt->bindParam(2, $idInscriptions, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Tag RFID mis à jour avec succès"]);
        } else {
            echo json_encode(["success" => false, "message" => "Aucune mise à jour effectuée"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour", "details" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Paramètres manquants"]);
}
?>