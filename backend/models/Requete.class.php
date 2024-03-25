<?php

class Requete {
    private $id_requete;
    private $adresse_ip_req;
    private $id_utilisateur_req;
    private $mot_de_passe_req;
    private $email_req;
    private $date_heure_req;

    public function __construct($id_requete, $adresse_ip_req, $mot_de_passe_req, $email_req, $id_utilisateur_req, $date_heure_req) {
        $this->id_requete = $id_requete;
        $this->adresse_ip_req = $adresse_ip_req;
        $this->mot_de_passe_req = $mot_de_passe_req;
        $this->email_req = $email_req;
        $this->id_utilisateur_req = $id_utilisateur_req;
        $this->date_heure_req = $date_heure_req;
    }

    public function getIdReq() {
        return $this->id_requete;
    }

    public function getDateHeureRequete() {
        return $this->date_heure_req;
    }

    public function setDateHeureRequete($date_heure_req) {
        $this->date_heure_req = $date_heure_req;
    }

    public function getAdresseIp() {
        return $this->adresse_ip_req;
    }

    public function setAdresseIp($adresse_ip_req) {
        $this->adresse_ip_req = $adresse_ip_req;
    }

    public function getIdUtilisateurReq() {
        return $this->id_utilisateur_req;
    }

    public function setIdUtilisateurReq($id_utilisateur_req) {
        $this->id_utilisateur_req = $id_utilisateur_req;
    }
}
