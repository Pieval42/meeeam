<?php

class ReseauSocial {
    private $id_reseau_social;
    private $nom_reseau_social;

    public function __construct($id_reseau_social, $nom_reseau_social) {
        $this->id_reseau_social = $id_reseau_social;
        $this->nom_reseau_social = $nom_reseau_social;
    }

    public function getIdReseauSocial() {
        return $this->id_reseau_social;
    }

    public function setIdReseauSocial($id_reseau_social) {
        $this->id_reseau_social = $id_reseau_social;
    }

    public function getNomReseauSocial() {
        return $this->nom_reseau_social;
    }

    public function setNomReseauSocial($nom_reseau_social) {
        $this->nom_reseau_social = $nom_reseau_social;
    }
}
