<?php

class TypeAbonnement {
    private $id_type_abo;
    private $libelle_type_abo;
    private $duree_type_abo;
    private $prix_type_abo;

    public function __construct($id_type_abo, $libelle_type_abo, $duree_type_abo, $prix_type_abo) {
        $this->id_type_abo = $id_type_abo;
        $this->libelle_type_abo = $libelle_type_abo;
        $this->duree_type_abo = $duree_type_abo;
        $this->prix_type_abo = $prix_type_abo;
    }

    public function getIdTypeAbo() {
        return $this->id_type_abo;
    }

    public function setIdTypeAbo($id_type_abo) {
        $this->id_type_abo = $id_type_abo;
    }

    public function getLibelleTypeAbo() {
        return $this->libelle_type_abo;
    }

    public function setLibelleTypeAbo($libelle_type_abo) {
        $this->libelle_type_abo = $libelle_type_abo;
    }

    public function getDureeTypeAbo() {
        return $this->duree_type_abo;
    }

    public function setDureeTypeAbo($duree_type_abo) {
        $this->duree_type_abo = $duree_type_abo;
    }

    public function getPrixTypeAbo() {
        return $this->prix_type_abo;
    }

    public function setPrixTypeAbo($prix_type_abo) {
        $this->prix_type_abo = $prix_type_abo;
    }
}
