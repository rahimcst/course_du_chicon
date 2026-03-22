<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';  // Inclure le fichier de connexion
require_once __DIR__ . '/../../dal/InscriptionDAL.php';  // Inclure la classe InscriptionDAL

// Instancier la classe InscriptionDAL
$inscriptionDAL = new InscriptionDAL($pdo);

try {
    // Appeler la méthode getInscriptions pour récupérer les inscriptions
    $inscriptions = $inscriptionDAL->getInscriptions1();

    // Vérifier si des inscriptions ont été trouvées
    if (count($inscriptions) > 0) {
        echo json_encode(["success" => true, "inscriptions" => $inscriptions]);
    } else {
        echo json_encode(["success" => false, "message" => "Aucune inscription trouvée"]);
    }
} catch (PDOException $e) {
    // Si une exception se produit (erreur SQL), renvoyer l'erreur dans le format JSON
    echo json_encode(["success" => false, "message" => "Erreur lors de la récupération des inscriptions", "details" => $e->getMessage()]);
}
?>
