<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';  // Inclure le fichier de connexion
require_once __DIR__ . '/../../dal/InscriptionDAL.php';  // Inclure le fichier DAL

$inscriptionDAL = new InscriptionDAL($pdo); // Assurez-vous que $pdo est bien initialisé

// Vérifier si le paramètre courseId est fourni et est un nombre valide
if (isset($_GET['courseId']) && is_numeric($_GET['courseId'])) {
    $courseId = (int) $_GET['courseId'];

    try {
        $participants = $inscriptionDAL->getInscriptions2($courseId); // 🔥 CORRECTION ICI 🔥

        // Retourner la réponse en JSON
        echo json_encode(["success" => true, "participants" => $participants]);
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Erreur lors de la récupération des données",
            "details" => $e->getMessage()
        ]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No courseId provided or invalid"]);
}
?>
