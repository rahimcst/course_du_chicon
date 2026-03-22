<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../../config/database.php';  // Inclure le fichier de connexion
require_once '../../dal/CourseDAL.php';  // Inclure la classe CourseDAL

try {
    // Instancier la classe CourseDAL avec PDO
    $courses = new CourseDAL($pdo);
    
    // Récupérer toutes les courses
    $result = $courses->getAll();

    // Vérifier si des courses existent
    if (!empty($result)) {
        // Forcer la conversion de idCourses en entier pour chaque ligne
        foreach ($result as &$course) {
            $course['idCourses'] = (int) $course['idCourses'];  // Assurer que idCourses est un entier
        }

        // Renvoyer le résultat en format JSON
        echo json_encode(["success" => true, "courses" => $result]);
    } else {
        echo json_encode(["success" => false, "message" => "Aucune course trouvée"]);
    }

} catch (PDOException $e) {
    echo json_encode([
        "success" => false, 
        "message" => "Erreur lors de la récupération des courses", 
        "details" => $e->getMessage()
    ]);
}
?>
