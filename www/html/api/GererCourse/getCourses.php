<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../../config/database.php';  // Inclure le fichier de connexion

try {
    $sql = "SELECT * FROM courses";
    $stmt = $pdo->query($sql);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($courses);
} catch (Exception $e) {
    echo json_encode(["message" => "Erreur lors de la récupération des données", "error" => $e->getMessage()]);
}
?>
