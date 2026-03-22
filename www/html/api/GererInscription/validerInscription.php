<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';
require_once '../../models/Mail.php';

// Récupérer les données dans tous les cas : body JSON, POST, ou GET
$data = json_decode(file_get_contents("php://input"), true);

$idInscription = null;
$statut = null;

// 1. Si appels JSON
if (is_array($data) && isset($data['idInscription']) && isset($data['statut'])) {
    $idInscription = $data['idInscription'];
    $statut = $data['statut'];
}
// 2. Sinon POST classique
elseif (isset($_POST['idInscription']) && isset($_POST['statut'])) {
    $idInscription = $_POST['idInscription'];
    $statut = $_POST['statut'];
}
// 3. Sinon GET (URL)
elseif (isset($_GET['idInscription']) && isset($_GET['statut'])) {
    $idInscription = $_GET['idInscription'];
    $statut = $_GET['statut'];
}

if (!is_null($idInscription) && !is_null($statut)) {
    $idInscription = intval($idInscription);

    $query = "UPDATE inscriptions SET statut_inscription = ? WHERE idInscriptions = ?";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $statut, PDO::PARAM_STR);
        $stmt->bindParam(2, $idInscription, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Récupérer email et nom de la course
            $queryInfo = "
                SELECT p.mail AS email, c.intitule AS nom_course
                FROM inscriptions i
                JOIN participants p ON i.idParticipant = p.idParticipants
                JOIN courses c ON i.idCourse = c.idCourses
                WHERE i.idInscriptions = ?";
            $stmtInfo = $pdo->prepare($queryInfo);
            $stmtInfo->bindParam(1, $idInscription, PDO::PARAM_INT);
            $stmtInfo->execute();

            $info = $stmtInfo->fetch(PDO::FETCH_ASSOC);

            if ($info && !empty($info['email'])) {
                $destinataire = $info['email'];
                $nomCourse = $info['nom_course'];

                if (strtolower($statut) === 'approuvée' || strtolower($statut) === 'approuvee') {
                    $contenu = "Votre inscription pour la course <strong>" . htmlspecialchars($nomCourse) . "</strong> a été <b>approuvée</b>.<br> À bientôt sur la ligne de départ !";
                } else {
                    $contenu = "Votre inscription pour la course <strong>" . htmlspecialchars($nomCourse) . "</strong> a été <b>refusée</b>.<br> Veuillez nous contacter pour plus d’informations.";
                }

                $mail = new Mail();
                $resultMail = $mail->envoyerMail($destinataire, "Statut de votre inscription - CourseDuChicon", $contenu);
                if ($resultMail !== true) {
                    echo json_encode(["success" => true, "message" => "Inscription mise à jour, mais erreur lors de l'envoi du mail", "mailError" => $resultMail]);
                    exit;
                }
            }

            echo json_encode(["success" => true, "message" => "Inscription mise à jour et mail envoyé"]);
        } else {
            echo json_encode(["success" => false, "message" => "Aucune modification effectuée"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur d'exécution", "details" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Données manquantes"]);
}
?>