<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../../config/database.php';  // Inclure le fichier de connexion

if (isset($_GET['idCourse'])) {
    $idCourse = htmlspecialchars($_GET['idCourse']);

    try {
        $sql = "DELETE FROM courses WHERE idCourses = :idCourse";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCourse', $idCourse, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Course supprimée"]);
        } else {
            echo json_encode(["message" => "Erreur lors de la suppression"]);
        }
    } catch (Exception $e) {
        echo json_encode(["message" => "Erreur", "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["message" => "Données manquantes"]);
}
?>
