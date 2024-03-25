<?php

class ProfilReseauSocial {
    private $id_reseau_social_fk;
    private $id_profil_reseau_social;
    private $lien_profil;
    private $id_utilisateur_profil_reseau_social;

    public function __construct($id_reseau_social_fk, $id_profil_reseau_social, $lien_profil, $id_utilisateur_profil_reseau_social) {
        $this->id_reseau_social_fk = $id_reseau_social_fk;
        $this->id_profil_reseau_social = $id_profil_reseau_social;
        $this->lien_profil = $lien_profil;
        $this->id_utilisateur_profil_reseau_social = $id_utilisateur_profil_reseau_social;
    }

    public function getIdReseauSocialFk() {
        return $this->id_reseau_social_fk;
    }

    public function setIdReseauSocialFk($id_reseau_social_fk) {
        $this->id_reseau_social_fk = $id_reseau_social_fk;
    }

    public function getIdProfilReseauSocial() {
        return $this->id_profil_reseau_social;
    }

    public function setIdProfilReseauSocial($id_profil_reseau_social) {
        $this->id_profil_reseau_social = $id_profil_reseau_social;
    }

    public function getLienProfil() {
        return $this->lien_profil;
    }

    public function setLienProfil($lien_profil) {
        $this->lien_profil = $lien_profil;
    }

    public function getIdUtilisateurProfilReseauSocial() {
        return $this->id_utilisateur_profil_reseau_social;
    }

    public function setIdUtilisateurProfilReseauSocial($id_utilisateur_profil_reseau_social) {
        $this->id_utilisateur_profil_reseau_social = $id_utilisateur_profil_reseau_social;
    }
}
