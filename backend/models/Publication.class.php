<?php

class Publication {
    private $id_publication;
    private $contenu_publication;
    private $date_heure_publication;
    private $id_type_fichier_publication;
    private $id_fichier_publication;
    private $id_page_publique_publication;
    private $id_page_profil_publication;
    private $id_utilisateur_page_profil;
    private $id_createur_publication;

    public function __construct($id_publication, $contenu_publication, $date_heure_publication, $id_type_fichier_publication, $id_fichier_publication, $id_page_publique_publication, $id_page_profil_publication, $id_utilisateur_page_profil, $id_createur_publication) {
        $this->id_publication = $id_publication;
        $this->contenu_publication = $contenu_publication;
        $this->date_heure_publication = $date_heure_publication;
        $this->id_type_fichier_publication = $id_type_fichier_publication;
        $this->id_fichier_publication = $id_fichier_publication;
        $this->id_page_publique_publication = $id_page_publique_publication;
        $this->id_page_profil_publication = $id_page_profil_publication;
        $this->id_utilisateur_page_profil = $id_utilisateur_page_profil;
        $this->id_createur_publication = $id_createur_publication;
    }

    public function getIdPublication() {
        return $this->id_publication;
    }

    public function getContenuPublication() {
        return $this->contenu_publication;
    }

    public function setContenuPublication($contenu_publication) {
        $this->contenu_publication = $contenu_publication;
    }

    public function getDateHeurePublication() {
        return $this->date_heure_publication;
    }

    public function setDateHeurePublication($date_heure_publication) {
        $this->date_heure_publication = $date_heure_publication;
    }

    public function getIdTypeFichierPublication() {
        return $this->id_type_fichier_publication;
    }

    public function setIdTypeFichierPublication($id_type_fichier_publication) {
        $this->id_type_fichier_publication = $id_type_fichier_publication;
    }

    public function getIdFichierPublication() {
        return $this->id_fichier_publication;
    }

    public function setIdFichierPublication($id_fichier_publication) {
        $this->id_fichier_publication = $id_fichier_publication;
    }

    public function getIdPagePubliquePublication() {
        return $this->id_page_publique_publication;
    }

    public function setIdPagePubliquePublication($id_page_publique_publication) {
        $this->id_page_publique_publication = $id_page_publique_publication;
    }

    public function getIdPageProfilPublication() {
        return $this->id_page_profil_publication;
    }

    public function setIdPageProfilPublication($id_page_profil_publication) {
        $this->id_page_profil_publication = $id_page_profil_publication;
    }

    public function getIdUtilisateurPageProfil() {
        return $this->id_utilisateur_page_profil;
    }

    public function getIdCreateurPublication() {
        return $this->id_createur_publication;
    }
}
