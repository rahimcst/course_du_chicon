<?php
require_once __DIR__ . '/../models/Course.php';


class CourseDAL
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM courses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Utilisation de FETCH_ASSOC
    }


    public function getAllOpen()
    {
        $stmt = $this->pdo->query("SELECT * FROM courses WHERE statut = 'InscriptionOpen'");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Course');
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE idCourses = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject('Course');
    }

    public function insert(Course $course)
    {
        $stmt = $this->pdo->prepare("INSERT INTO courses (intitule, distance, date, statut, dateLimite) 
            VALUES (:intitule, :distance, :date, :statut, :dateLimite)");
        $stmt->execute([
            'intitule' => $course->intitule,
            'distance' => $course->distance,
            'date' => $course->date,
            'statut' => $course->statut,
            'dateLimite' => $course->dateLimite
        ]);
        return $this->pdo->lastInsertId();
    }

    public function insertStatut($id)
    {
        $stmt = $this->pdo->prepare("UPDATE courses SET statut = 'Chrono' WHERE idCourses = :id");
        $stmt->execute(['id' => $id]);
    }

    public function updateCourseStatus($courseId, $newStatus)
    {
        $stmt = $this->pdo->prepare("UPDATE courses SET statut = :statut WHERE idCourses = :courseId");
        $stmt->bindParam(':statut', $newStatus);
        $stmt->bindParam(':courseId', $courseId);
        return $stmt->execute();
    }

    public function resultatCourse()
    {
        $stmt = $this->pdo->prepare('SELECT idCourses, intitule, distance, date FROM courses WHERE statut = "Finished" ORDER BY date DESC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateStatusChrono($courseId)
    {
        $stmt = $this->pdo->prepare("
        UPDATE courses
        SET statut = 'Chrono'
        WHERE idCourses = :id AND statut = 'Ready'
    ");

        $stmt->execute([':id' => $courseId]);
        return $stmt->rowCount() > 0;
    }

    public function updateStatusFinished($courseId)
    {
        $stmt = $this->pdo->prepare("
        UPDATE courses
        SET statut = 'Finished'
        WHERE idCourses = :id AND statut = 'Chrono'
    ");

        $stmt->execute([':id' => $courseId]);
        return $stmt->rowCount() > 0;
    }
}


?>