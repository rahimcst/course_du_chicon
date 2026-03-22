<?php
require_once __DIR__ . '/../models/Inscription.php';

class InscriptionDAL
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM inscriptions");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Inscription');
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM inscriptions WHERE idInscriptions = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject('Inscription');
    }

    public function insert(Inscription $inscription)
    {
        $stmt = $this->pdo->prepare("INSERT INTO inscriptions (idParticipant, idCourse, chrono, statut_inscription, tagRFID, numeroDossard) 
            VALUES (:idParticipant, :idCourse, :chrono, :statut_inscription, :tagRFID, :numeroDossard)");
        $stmt->execute([
            'idParticipant' => $inscription->idParticipant,
            'idCourse' => $inscription->idCourse,
            'chrono' => $inscription->chrono,
            'statut_inscription' => $inscription->statut_inscription,
            'tagRFID' => $inscription->tagRFID,
            'numeroDossard' => $inscription->numeroDossard
        ]);
        return $this->pdo->lastInsertId();
    }

    // Récupérer toutes les inscriptions avec les détails du participant et de la course
    public function getAllInscriptions()
    {
        $sql = "
            SELECT i.idInscriptions, p.nom, p.prenom, p.date_naissance, p.licence, 
                   i.statut_inscription, i.numeroDossard, i.tagRFID, 
                   COALESCE(c.intitule, '') AS course  -- Évite les valeurs NULL
            FROM inscriptions i
            INNER JOIN participants p ON i.idParticipant = p.idParticipants
            LEFT JOIN courses c ON i.idCourse = c.idCourses
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getInscriptions1()
    {
        // Requête SQL pour récupérer les inscriptions avec les détails des participants et des courses
        $query = "
         SELECT i.idInscriptions, p.nom, p.prenom, p.date_naissance, p.licence, 
                i.statut_inscription, i.numeroDossard, i.tagRFID, c.intitule AS course
         FROM inscriptions i
         INNER JOIN participants p ON i.idParticipant = p.idParticipants
         INNER JOIN courses c ON i.idCourse = c.idCourses WHERE c.statut = 'InscriptionOpen';
     ";

        try {
            // Préparer et exécuter la requête
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            // Récupérer les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si une erreur se produit, renvoyer l'exception
            throw new PDOException("Erreur lors de la récupération des inscriptions : " . $e->getMessage());
        }
    }

    public function getInscriptions2($courseId)
    {
        // Requête SQL pour récupérer les inscriptions avec les détails des participants et des courses
        $query = "
    SELECT i.idInscriptions, p.idParticipants, p.nom, p.prenom, i.numeroDossard, i.tagRFID
    FROM inscriptions i
    INNER JOIN participants p ON i.idParticipant = p.idParticipants
    WHERE i.idCourse = ?
    ";
        try {
            // Préparer et exécuter la requête
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$courseId]);

            // Récupérer les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si une erreur se produit, renvoyer l'exception
            throw new PDOException("Erreur lors de la récupération des inscriptions : " . $e->getMessage());
        }
    }

    public function getCoursesByParticipantId($participantId)
    {
        $query = "
        SELECT c.*, i.statut_inscription
        FROM inscriptions i
        INNER JOIN courses c ON i.idCourse = c.idCourses
        WHERE i.idParticipant = :participantId
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['participantId' => $participantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // 
    }

    public function deleteByParticipantAndCourse($participantId, $courseId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM inscriptions WHERE idParticipant = :participantId AND idCourse = :courseId");
        return $stmt->execute([
            'participantId' => $participantId,
            'courseId' => $courseId
        ]);
    }

    public function mettreAJourChrono($tagRFID, $chrono)
    {
        $stmt = $this->pdo->prepare("
        UPDATE inscriptions i
        INNER JOIN courses c ON i.idCourse = c.idCourses
        SET i.chrono = :chrono
        WHERE i.tagRFID = :tag_rfid
        AND c.statut = 'Chrono'
    ");

        $stmt->execute([
            ':chrono' => $chrono,
            ':tag_rfid' => $tagRFID
        ]);

        var_dump($stmt->rowCount()); // ← Ajoute ça pour voir le résultat
        return $stmt->rowCount() > 0;
    }
    public function getResultatsPublies($courseId)
    {
        $stmt = $this->pdo->prepare("
        SELECT p.nom, p.prenom, i.chrono, i.numeroDossard
        FROM inscriptions i
        INNER JOIN participants p ON i.idParticipant = p.idParticipant
        WHERE i.idCourse = :id
        AND p.autorisation = 1
        ORDER BY i.chrono ASC
    ");
        $stmt->execute([':id' => $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllParticipantsWithAutorisation($courseId)
    {
        $stmt = $this->pdo->prepare("
        SELECT p.nom, p.prenom, i.chrono, i.numeroDossard, p.autorisation
        FROM inscriptions i
        INNER JOIN participants p ON i.idParticipant = p.idParticipants
        WHERE i.idCourse = :id
        ORDER BY i.chrono ASC
    ");
        $stmt->execute([':id' => $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>