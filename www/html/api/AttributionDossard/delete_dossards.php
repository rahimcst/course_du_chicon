<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';

// Récupérer courseId : JSON (PUT/POST), POST, ou GET
$data = json_decode(file_get_contents("php://input"), true);

$courseId = null;
if (is_array($data) && isset($data['courseId']) && is_numeric($data['courseId'])) {
    $courseId = intval($data['courseId']);
} elseif (isset($_POST['courseId']) && is_numeric($_POST['courseId'])) {
    $courseId = intval($_POST['courseId']);
} elseif (isset($_GET['courseId']) && is_numeric($_GET['courseId'])) {
    $courseId = intval($_GET['courseId']);
}

if (!is_null($courseId)) {
    try {
        $query = "UPDATE inscriptions SET numeroDossard = NULL WHERE idCourse = :courseId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Tous les numéros de dossards ont été supprimés pour la course $courseId",
                "affectedRows" => $stmt->rowCount()
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erreur lors de la suppression des dossards"
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Erreur SQL",
            "details" => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Aucun courseId valide fourni"
    ]);
}
?>