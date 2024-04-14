<?php
require_once __DIR__ . "/../" . 'Model.class.php';
require_once __DIR__ . "/../" . 'LogUtilisateur.class.php';
require_once __DIR__ . "/../" . 'Utilisateur.class.php';

class LogManager extends Model {
    
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