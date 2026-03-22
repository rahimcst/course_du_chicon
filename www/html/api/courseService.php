<?php
header("Content-Type: application/json");

require_once '../models/course.php'; // Inclure la classe Course
require_once '../dal/courseDAL.php'; // Inclure la classe CourseDAL


$courseDAL = new CourseDAL($pdo);

// Récupérer l'ID depuis l'URL si nécessaire
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Gérer la méthode de la requête
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($id) {
            // Si un ID est spécifié, récupérer une course par son ID
            $course = $courseDAL->getById($id);
            if ($course) {
                echo json_encode($course);
            } else {
                echo json_encode(['message' => 'Course not found']);
            }
        } else {
            // Récupérer toutes les courses
            $courses = $courseDAL->getAll();
            echo json_encode($courses);
        }
        break;

    case 'POST':
        // Insérer une nouvelle course
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['intitule'], $data['distance'], $data['date'], $data['statut'], $data['dateLimite'])) {
            $course = new Course();
            $course->intitule = $data['intitule'];
            $course->distance = $data['distance'];
            $course->date = $data['date'];
            $course->statut = $data['statut'];
            $course->dateLimite = $data['dateLimite'];

            $insertedId = $courseDAL->insert($course);
            echo json_encode(['message' => 'Course created', 'id' => $insertedId]);
        } else {
            echo json_encode(['message' => 'Missing parameters']);
        }
        break;

    default:
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
?>
