<?php
header("Content-Type: application/json");

// Inclure la connexion à la base de données
require_once '../../config/database.php';  // Inclure le fichier de connexion

// GET Courses
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT * FROM courses");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur lors de la récupération des courses", "error" => $e->getMessage()]);
    }
}

// POST Course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['intitule'], $data['distance'], $data['date'], $data['statut'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO courses (intitule, distance, date, statut) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['intitule'], $data['distance'], $data['date'], $data['statut']]);
            echo json_encode(["success" => true, "message" => "Course ajoutée avec succès"]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout de la course", "error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Données manquantes"]);
    }
}

// DELETE Course
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM courses WHERE idCourses = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) {
                echo json_encode(["success" => true, "message" => "Course supprimée avec succès"]);
            } else {
                echo json_encode(["success" => false, "message" => "Course non trouvée"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression de la course", "error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "ID manquant ou invalide"]);
    }
}
?>
