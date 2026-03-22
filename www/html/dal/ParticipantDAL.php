<?php
require_once __DIR__ . '/../models/Participant.php';

class ParticipantDAL
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert($participant)
    {
        $sql = "INSERT INTO participants (nom, prenom, date_naissance, adresse, mail, autorisation, password)
                VALUES (:nom, :prenom, :date_naissance, :adresse, :mail, :autorisation, :password)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':nom', $participant->nom);
        $stmt->bindParam(':prenom', $participant->prenom);
        $stmt->bindParam(':date_naissance', $participant->date_naissance);
        $stmt->bindParam(':adresse', $participant->adresse);
        $stmt->bindParam(':mail', $participant->mail);
        $stmt->bindParam(':autorisation', $participant->autorisation);
        $stmt->bindParam(':password', $participant->password);

        return $stmt->execute();
    }

    public function getByEmail($email)
    {
        try {
            // Assure-toi que tu récupères toutes les colonnes nécessaires
            $stmt = $this->pdo->prepare("SELECT idParticipants, mail, prenom, nom, compte_actif, date_naissance, password FROM participants WHERE mail = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Si l'utilisateur existe, retourne l'objet correspondant
            return $stmt->fetchObject('Participant');
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des données : " . $e->getMessage();
            return null;
        }
    }


    // Récupérer un participant par son ID
    public function getById($id)
    {
        $sql = "SELECT * FROM participants WHERE idParticipants = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Récupérer l'inscription d'un participant
    public function getInscriptionByParticipantId($id)
    {
        $sql = "SELECT * FROM inscriptions WHERE idParticipant = :idParticipant";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idParticipant', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function activerCompte($email)
    {
        $sql = "UPDATE participants SET compte_actif = 1 WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $email);
        return $stmt->execute();
    }

    public function updateTokenConfirmation($email, $token)
    {
        $sql = "UPDATE participants SET token_confirmation = :token WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    public function getByToken($token)
    {
        $sql = "SELECT * FROM participants WHERE token_confirmation = :token";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Vérifier si l'email existe
    public function checkEmailExists($email)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM participants WHERE mail = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    // Récupérer l'ID d'un participant par email
    public function getIdByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT idParticipants FROM participants WHERE mail = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn();
    }

    public function updatePassword($idParticipant, $newPassword)
    {
        try {
            // Hachage du nouveau mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // PRÉPARER LA REQUÊTE SQL POUR METTRE À JOUR LE MOT DE PASSE
            $stmt = $this->pdo->prepare("UPDATE participants SET password = :password WHERE mail = :mail");

            // LIER LES PARAMÈTRES
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':mail', $idParticipant);

            // EXÉCUTER LA REQUÊTE
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du mot de passe: " . $e->getMessage();
            return false;
        }
    }

    public function deleteById($participantId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM participants WHERE idParticipants = :id");
        return $stmt->execute(['id' => $participantId]);
    }

}
?>