<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';

// Récupérer les données JSON envoyées par le client
$data = json_decode(file_get_contents("php://input"), true);

// Pour une inscription de dernière minute, nous attendons : nom, prenom, date_naissance et idCourse
if (isset($data["nom"], $data["prenom"], $data["date_naissance"], $data["idCourse"])) {
    // Récupérer et échapper les données
    $nom = $data["nom"]; // Pas besoin de quotes dans les variables PHP
    $prenom = $data["prenom"];
    $date_naissance = $data["date_naissance"];
    // Le champ licence est optionnel
    $licence = isset($data["licence"]) ? $data["licence"] : NULL;
    $idCourse = intval($data["idCourse"]);

    // Valeurs par défaut pour les autres champs obligatoires
    $adresse = ""; // Laisser NULL si pas de valeur
    $autorisation = 1; // Valeur par défaut (1 = autorisé)
    $passwordValue = ""; // Valeur par défaut pour le password
    $mail = ""; // Mail par défaut
    $compte_actif = 0; // Par défaut, le compte n'est pas actif

    try {
        // Préparer la requête pour insérer un participant complet
        $query = "INSERT INTO participants (nom, prenom, date_naissance, adresse, licence, autorisation, password, mail, compte_actif) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);

        // Lier les paramètres avec le bon type
        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->bindParam(2, $prenom, PDO::PARAM_STR);
        $stmt->bindParam(3, $date_naissance, PDO::PARAM_STR);
        $stmt->bindParam(4, $adresse, PDO::PARAM_STR); // Permet d'insérer NULL dans le champ adresse
        $stmt->bindParam(5, $licence, PDO::PARAM_STR);
        $stmt->bindParam(6, $autorisation, PDO::PARAM_INT);
        $stmt->bindParam(7, $passwordValue, PDO::PARAM_STR);
        $stmt->bindParam(8, $mail, PDO::PARAM_STR);
        $stmt->bindParam(9, $compte_actif, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $idParticipant = $pdo->lastInsertId();

            // Préparer la requête pour insérer l'inscription
            $query2 = "INSERT INTO inscriptions (idParticipant, idCourse, statut_inscription) 
                       VALUES (?, ?, 'Approuvée')";
            $stmt2 = $pdo->prepare($query2);
            $stmt2->bindParam(1, $idParticipant, PDO::PARAM_INT);
            $stmt2->bindParam(2, $idCourse, PDO::PARAM_INT);

            if ($stmt2->execute()) {
                echo json_encode(["success" => true, "message" => "Inscription ajoutée avec succès"]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Erreur lors de l'inscription", 
                    "details" => $stmt2->errorInfo()
                ]);
            }
        } else {
            echo json_encode([
                "success" => false, 
                "message" => "Erreur lors de l'ajout du participant", 
                "details" => $stmt->errorInfo()
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false, 
            "message" => "Erreur lors de l'exécution des requêtes", 
            "details" => $e->getMessage()
        ]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Données manquantes"]);
}
?>
