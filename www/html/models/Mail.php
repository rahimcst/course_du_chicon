<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
echo realpath('../PHPMailer/src/PHPMailer.php');
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

class Mail {
    private $mail;
    private $subject;

    public function __construct($subject = "Confirmation de votre inscription") {
        $this->mail = new PHPMailer(true);
        
        // Configuration SMTP Brevo
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp-relay.brevo.com'; 
        $this->mail->SMTPAuth = true;
        $this->mail->AuthType = 'LOGIN';
        $this->mail->Username = ''; 
        $this->mail->Password = ''; // Clé API Brevo
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->CharSet = 'UTF-8';
        $this->subject = $subject;
        // Expéditeur
        $this->mail->setFrom('courseduchicon.baisieux@gmail.com');
    }

    public function envoyerMail($destinataire, $sujet, $message) {
        try {
            // Destinataire
            $this->mail->addAddress($destinataire);

            // Contenu du mail
            $this->mail->isHTML(true);
            $this->mail->Subject = $sujet;
            $this->mail->Body    = $message;

            // Envoyer l'email
            $this->mail->send();
            return true;  // Si l'email est envoyé avec succès
        } catch (Exception $e) {
            return "Erreur lors de l'envoi du mail : {$this->mail->ErrorInfo}";
        }
    }
}
?>
