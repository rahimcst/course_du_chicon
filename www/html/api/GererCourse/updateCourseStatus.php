<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';  // Inclure le fichier de connexion

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents("php://input"));

if (is_object($data) && isset($data->idCourse) && isset($data->statut)) {
    $idCourse = htmlspecialchars($data->idCourse);
    $statut = htmlspecialchars($data->statut);

    $sql = "UPDATE courses SET statut = :statut WHERE idCourses = :idCourse";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':idCourse', $idCourse);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Statut mis à jour"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la mise à jour"]);
    }
} else {
    echo json_encode(["message" => "Données manquantes"]);
}
?>