<?php

require_once 'Model.class.php';
require_once 'LogUtilisateur.class.php';
require_once 'Utilisateur.class.php';

class ConnexionManager extends Model {
    // private $connexion;
    
    // public function ajoutConnexion($connexion){
    //     $this->connexion = $connexion;
    // }

    // public function creerConnexion() {
        
    // }
    
    // public function getConnexion(){
    //     return $this->connexion;
    // }

    public function creerLogConnexion($id_utilisateur, $adresse_ip) {
        $req = "
            INSERT INTO log_utilisateur
            (id_utilisateur, adresse_ip)
            VALUES (:id_utilisateur, :adresse_ip)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur,PDO::PARAM_INT);
        $stmt->bindValue(':adresse_ip', $adresse_ip, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }
}

?>