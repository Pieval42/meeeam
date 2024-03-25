<?php

class PageProfil {
    private $id_utilisateur_page_profil;
    private $id_page_profil;

    public function __construct($id_utilisateur_page_profil, $id_page_profil) {
        $this->id_utilisateur_page_profil = $id_utilisateur_page_profil;
        $this->id_page_profil = $id_page_profil;
    }

    public function getIdUtilisateurPageProfil() {
        return $this->id_utilisateur_page_profil;
    }

    public function setIdUtilisateurPageProfil($id_utilisateur_page_profil) {
        $this->id_utilisateur_page_profil = $id_utilisateur_page_profil;
    }

    public function getIdPageProfil() {
        return $this->id_page_profil;
    }
}
