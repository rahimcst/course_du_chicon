<?php
if (!class_exists('MyPDO')) {
class MyPDO extends PDO {
    // Définir les propriétés de la classe pour la connexion
    private $dsn = 'mysql:host=127.0.0.1;dbname=course_chicon'; 
    private $username = 'etudiantciel';  
    private $password = 'BTSbts22';  

    // Constructeur pour tester la connexion
    public function __construct() {
        try {
            parent::__construct($this->dsn, $this->username, $this->password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
    }
}

$pdo = new MyPDO();
}
?>
