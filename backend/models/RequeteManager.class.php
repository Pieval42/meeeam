<?php

require_once 'Model.class.php';
require_once 'Requete.class.php';

class RequeteManager extends Model {

    //Brute force protection - Limit requests
    public function getNbRequetesByIp($adresse_ip)
    {
        $req =  "   SELECT COUNT(*) FROM requete
                    WHERE adresse_ip_req = :adresse_ip_req AND date_heure_req > DATE_SUB(NOW(), 
                    INTERVAL 1 HOUR)
                ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':adresse_ip_req', $adresse_ip, PDO::PARAM_STR);
        $stmt->execute();
        $nbrequetes = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $nbrequetes;
    }

    public function getRequetesByEmail($email)
    {
        $req =  "   SELECT * FROM requete
                    WHERE email_req = :email AND date_heure_req > DATE_SUB(NOW(), 
                    INTERVAL 1 HOUR)
                ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($res as $key => $value ){
            $requetes[$key] = $value;
        }
        return $requetes;
    }

    public function creerRequete($id_utilisateur, $adresse_ip, $mot_de_passe, $email, $type_req) {
        $req =  "   INSERT INTO requete
                    (id_utilisateur_req, adresse_ip_req, mot_de_passe_req, email_req, type_req)
                    VALUES (:id_utilisateur, :adresse_ip, :mot_de_passe, :email, :type_req)
                ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur,PDO::PARAM_INT);
        $stmt->bindValue(':adresse_ip', $adresse_ip, PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':type_req', $type_req, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    //Limitation of access time
    public function getHeureRequeteByIp($adresse_ip)
    {
        $req =  "   SELECT date_heure_req FROM requete
                    WHERE adresse_ip_req = :adresse_ip 
                    ORDER BY date_heure_req 
                    DESC LIMIT 1
                ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':adresse_ip', $adresse_ip, PDO::PARAM_STR);
        $stmt->execute();
        $heure_requete = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $heure_requete;
    }

}

?>