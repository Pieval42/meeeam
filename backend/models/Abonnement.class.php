<?php

/**
 * Représentation de la table SQL `abonnement`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Abonnement {
    private $id_abonnement;
    private $date_souscription;
    private $date_fin;
    private $id_type_abo_fk;
    private $id_utilisateur_abonnement;

    public function __construct($id_abonnement, $date_souscription, $date_fin, $id_type_abo_fk, $id_utilisateur_abonnement) {
        $this->id_abonnement = $id_abonnement;
        $this->date_souscription = $date_souscription;
        $this->date_fin = $date_fin;
        $this->id_type_abo_fk = $id_type_abo_fk;
        $this->id_utilisateur_abonnement = $id_utilisateur_abonnement;
    }

    public function getIdAbonnement() {
        return $this->id_abonnement;
    }

    public function setIdAbonnement($id_abonnement) {
        $this->id_abonnement = $id_abonnement;
    }

    public function getDateSouscription() {
        return $this->date_souscription;
    }

    public function setDateSouscription($date_souscription) {
        $this->date_souscription = $date_souscription;
    }

    public function getDateFin() {
        return $this->date_fin;
    }

    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }

    public function getIdTypeAboFk() {
        return $this->id_type_abo_fk;
    }

    public function setIdTypeAboFk($id_type_abo_fk) {
        $this->id_type_abo_fk = $id_type_abo_fk;
    }

    public function getIdUtilisateurAbonnement() {
        return $this->id_utilisateur_abonnement;
    }

    public function setIdUtilisateurAbonnement($id_utilisateur_abonnement) {
        $this->id_utilisateur_abonnement = $id_utilisateur_abonnement;
    }
}
?>
