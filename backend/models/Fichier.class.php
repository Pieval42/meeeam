<?php

class Fichier {
    private $id_type_fichier_fk;
    private $id_fichier;
    private $nom_fichier;
    private $id_utilisateur_fichier;

    public function __construct($id_type_fichier_fk, $id_fichier, $nom_fichier, $id_utilisateur_fichier) {
        $this->id_type_fichier_fk = $id_type_fichier_fk;
        $this->id_fichier = $id_fichier;
        $this->nom_fichier = $nom_fichier;
        $this->id_utilisateur_fichier = $id_utilisateur_fichier;
    }

    public function getIdTypeFichierFk() {
        return $this->id_type_fichier_fk;
    }

    public function setIdTypeFichierFk($id_type_fichier_fk) {
        $this->id_type_fichier_fk = $id_type_fichier_fk;
    }

    public function getIdFichier() {
        return $this->id_fichier;
    }

    public function setIdFichier($id_fichier) {
        $this->id_fichier = $id_fichier;
    }

    public function getNomFichier() {
        return $this->nom_fichier;
    }

    public function setNomFichier($nom_fichier) {
        $this->nom_fichier = $nom_fichier;
    }

    public function getIdUtilisateurFichier() {
        return $this->id_utilisateur_fichier;
    }

    public function setIdUtilisateurFichier($id_utilisateur_fichier) {
        $this->id_utilisateur_fichier = $id_utilisateur_fichier;
    }
}
