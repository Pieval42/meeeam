<?php

class TypeFichier {
    private $id_type_fichier;
    private $libelle_type_fichier;

    public function __construct($id_type_fichier, $libelle_type_fichier) {
        $this->id_type_fichier = $id_type_fichier;
        $this->libelle_type_fichier = $libelle_type_fichier;
    }

    public function getIdTypeFichier() {
        return $this->id_type_fichier;
    }

    public function setIdTypeFichier($id_type_fichier) {
        $this->id_type_fichier = $id_type_fichier;
    }

    public function getLibelleTypeFichier() {
        return $this->libelle_type_fichier;
    }

    public function setLibelleTypeFichier($libelle_type_fichier) {
        $this->libelle_type_fichier = $libelle_type_fichier;
    }
}
