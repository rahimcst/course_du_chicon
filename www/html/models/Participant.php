<?php

class Participant {
    public $idParticipants;
    public $nom;
    public $prenom;
    public $date_naissance;
    public $adresse;
    public $mail;
    public $autorisation;
    public $password;
    public $compte_actif;
    public $token_confirmation;  // Ajout de la propriété token_confirmation


        // Getter pour nom
        public function getNom() {
            return $this->nom;
        }
    
        // Getter pour prenom
        public function getPrenom() {
            return $this->prenom;
        }
    
        // Getter pour email
        public function getEmail() {
            return $this->mail;
        }

                // Getter pour email
        public function getDateNaissance() {
            return $this->date_naissance;
        }
}

?>
