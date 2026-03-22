<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';


// Utilisation de $_POST au lieu de json_decode
if (isset($_POST['courseId']) && is_numeric($_POST['courseId'])) {
    $courseId = intval($_POST['courseId']);

    error_log("Course ID reçu : " . $courseId); // Debug

    // Requête pour récupérer les inscriptions sans dossard
    $query = "SELECT idInscriptions FROM inscriptions WHERE idCourse = :courseId AND numeroDossard IS NULL ORDER BY idInscriptions ASC";

    try {
        // Préparer et exécuter la requête
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
        $stmt->execute();

        $dossard = 1;
        $success = true;

        // Mettre à jour les inscriptions avec des dossards
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $updateQuery = "UPDATE inscriptions SET numeroDossard = :dossard WHERE idInscriptions = :idInscriptions";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':dossard', $dossard, PDO::PARAM_INT);
            $updateStmt->bindParam(':idInscriptions', $row['idInscriptions'], PDO::PARAM_INT);

            if (!$updateStmt->execute()) {
                $success = false;
            }
            $dossard++;
        }

        if ($success) {
            echo json_encode(["success" => true, "message" => "Dossards attribués avec succès"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'attribution des dossards"]);
        }

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Échec de la requête de récupération des inscriptions", "details" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Aucun courseId valide fourni"]);
}

?>