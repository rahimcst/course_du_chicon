<?php
header("Content-Type: application/json");

require_once '../config/database.php';
require_once '../models/Participant.php';
require_once '../dal/ParticipantDAL.php';

$participantDAL = new ParticipantDAL($pdo);

// Vérifier si la requête est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérification des champs obligatoires
    if (!isset($data['nom'], $data['prenom'], $data['date_naissance'], $data['mail'], $data['password'], $data['autorisation'])) {
        echo json_encode(['message' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    // Création d'un nouvel objet Participant
    $participant = new Participant();
    $participant->nom = htmlspecialchars(trim($data['nom']));
    $participant->prenom = htmlspecialchars(trim($data['prenom']));
    $participant->date_naissance = $data['date_naissance'];
    $participant->mail = filter_var($data['mail'], FILTER_VALIDATE_EMAIL) ? $data['mail'] : null;
    $participant->autorisation = filter_var($data['autorisation'], FILTER_VALIDATE_BOOLEAN);
    $participant->password = password_hash($data['password'], PASSWORD_BCRYPT); // Hachage du mot de passe

    // Vérification de l'email
    if (!$participant->mail) {
        echo json_encode(['message' => 'Adresse email invalide.']);
        exit;
    }

    // Insérer le participant dans la base
    $insertedId = $participantDAL->insert($participant);

    // Vérification de l'insertion
    if ($insertedId) {
        // Redirection vers la page de confirmation avec Bootstrap
        header("Location: confirmation.php?success=1");
        exit;
    } else {
        echo json_encode(['message' => 'Erreur lors de l\'inscription.']);
    }
} else {
    echo json_encode(['message' => 'Méthode non autorisée.']);
}
?>
