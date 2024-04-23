<?php

/**
 * Représentation de la table SQL `evenement`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Evenement {
    private $id_evenement;
    private $nom_evt;
    private $date_heure_evt;
    private $description_evt;
    private $id_ville_evenement;
    private $id_createur_evenement;

    public function __construct($id_evenement, $nom_evt, $date_heure_evt, $description_evt, $id_ville_evenement, $id_createur_evenement) {
        $this->id_evenement = $id_evenement;
        $this->nom_evt = $nom_evt;
        $this->date_heure_evt = $date_heure_evt;
        $this->description_evt = $description_evt;
        $this->id_ville_evenement = $id_ville_evenement;
        $this->id_createur_evenement = $id_createur_evenement;
    }

    public function getIdEvenement() {
        return $this->id_evenement;
    }

    public function setIdEvenement($id_evenement) {
        $this->id_evenement = $id_evenement;
    }

    public function getNomEvt() {
        return $this->nom_evt;
    }

    public function setNomEvt($nom_evt) {
        $this->nom_evt = $nom_evt;
    }

    public function getDateHeureEvt() {
        return $this->date_heure_evt;
    }

    public function setDateHeureEvt($date_heure_evt) {
        $this->date_heure_evt = $date_heure_evt;
    }

    public function getDescriptionEvt() {
        return $this->description_evt;
    }

    public function setDescriptionEvt($description_evt) {
        $this->description_evt = $description_evt;
    }

    public function getIdVilleEvenement() {
        return $this->id_ville_evenement;
    }

    public function setIdVilleEvenement($id_ville_evenement) {
        $this->id_ville_evenement = $id_ville_evenement;
    }

    public function getIdCreateurEvenement() {
        return $this->id_createur_evenement;
    }

    public function setIdCreateurEvenement($id_createur_evenement) {
        $this->id_createur_evenement = $id_createur_evenement;
    }
}
?>
