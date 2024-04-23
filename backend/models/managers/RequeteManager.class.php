<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../Requete.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `requete`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class RequeteManager extends Model
{    
    /**
     * Récupère le nombre de requêtes effectuées par l'adresse IP fournie dans la dernière heure
     *
     * @param  string $adresse_ip
     * 
     * @return array Tableau des requêtes correspondantes.
     */
    public function getNbRequetesByIp($adresse_ip)
    {
        $req =
        "SELECT COUNT(*) FROM requete
          WHERE adresse_ip_req = :adresse_ip_req AND date_heure_req > DATE_SUB(NOW(), 
          INTERVAL 1 HOUR)";
          
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":adresse_ip_req", $adresse_ip, PDO::PARAM_STR);
        $stmt->execute();
        $nbrequetes = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $nbrequetes;
    }
    
    /**
     * Récupère le nombre de requêtes effectuées par un utilisateur
     * correspondant à l'adresse e-mail fournie
     *
     * @param  string $email
     * 
     * @return array Tableau contenant les requêtes correspondantes.
     */
    public function getRequetesByEmail($email)
    {
        $req =
          "SELECT * FROM requete
            WHERE email_req = :email AND date_heure_req > DATE_SUB(NOW(), 
              INTERVAL 1 HOUR)";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $requetes = [];
        foreach ($res as $key => $value) {
            $requetes[$key] = $value;
        }
        return $requetes;
    }
    
    /**
     * Enregistre une requête
     *
     * @param  int    $id_utilisateur
     * @param  string $adresse_ip
     * @param  string $mot_de_passe
     * @param  string $email
     * @param  string $type_req
     * 
     * @return void
     */
    public function creerRequete(
        $id_utilisateur,
        $adresse_ip,
        $mot_de_passe,
        $email,
        $type_req
    ) {
        $req = "   INSERT INTO requete
                    (id_utilisateur_req, adresse_ip_req, mot_de_passe_req, email_req, type_req)
                    VALUES (:id_utilisateur, :adresse_ip, :mot_de_passe, :email, :type_req)
                ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
        $stmt->bindValue(":adresse_ip", $adresse_ip, PDO::PARAM_STR);
        $stmt->bindValue(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":type_req", $type_req, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    /**
     * Récupère la date et l'heure de la dernière requête correspondant à l'adresse IP fournie
     *
     * @param  mixed $adresse_ip
     * 
     * @return string Date et Heure de la requête correspondante.
     */
    public function getHeureRequeteByIp($adresse_ip)
    {
        $req =
          "SELECT date_heure_req FROM requete
            WHERE adresse_ip_req = :adresse_ip 
            ORDER BY date_heure_req 
            DESC LIMIT 1";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":adresse_ip", $adresse_ip, PDO::PARAM_STR);
        $stmt->execute();
        $heure_requete = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $heure_requete;
    }
}
?>
