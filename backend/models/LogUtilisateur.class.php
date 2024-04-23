<?php

/**
 * Représentation de la table SQL `log_utilisateur`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class LogUtilisateur {
    private $id_log;
    private $date_heure_connexion;
    private $date_heure_deconnexion;
    private $adresse_ip;
    private $id_utilisateur_log;

    public function __construct($id_log, $date_heure_connexion, $date_heure_deconnexion, $adresse_ip, $id_utilisateur_log) {
        $this->id_log = $id_log;
        $this->date_heure_connexion = $date_heure_connexion;
        $this->date_heure_deconnexion = $date_heure_deconnexion;
        $this->adresse_ip = $adresse_ip;
        $this->id_utilisateur_log = $id_utilisateur_log;
    }

    public function getIdLog() {
        return $this->id_log;
    }

    public function getDateHeureConnexion() {
        return $this->date_heure_connexion;
    }

    public function setDateHeureConnexion($date_heure_connexion) {
        $this->date_heure_connexion = $date_heure_connexion;
    }

    public function getDateHeureDeconnexion() {
        return $this->date_heure_deconnexion;
    }

    public function setDateHeureDeconnexion($date_heure_deconnexion) {
        $this->date_heure_deconnexion = $date_heure_deconnexion;
    }

    public function getAdresseIp() {
        return $this->adresse_ip;
    }

    public function setAdresseIp($adresse_ip) {
        $this->adresse_ip = $adresse_ip;
    }

    public function getIdUtilisateurLog() {
        return $this->id_utilisateur_log;
    }

    public function setIdUtilisateurLog($id_utilisateur_log) {
        $this->id_utilisateur_log = $id_utilisateur_log;
    }
}
?>
