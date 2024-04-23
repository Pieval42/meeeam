<?php

/**
 * Représentation de la table SQL `lister`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Lister {
    private $id_utilisateur_site_web;
    private $adresse_site_web_liste;

    public function __construct($id_utilisateur_site_web, $adresse_site_web_liste) {
        $this->id_utilisateur_site_web = $id_utilisateur_site_web;
        $this->adresse_site_web_liste = $adresse_site_web_liste;
    }

    public function getIdUtilisateurSiteWeb() {
        return $this->id_utilisateur_site_web;
    }

    public function getAdresseSiteWebListe() {
        return $this->adresse_site_web_liste;
    }

    public function setAdresseSiteWebListe($adresse_site_web_liste) {
        $this->adresse_site_web_liste = $adresse_site_web_liste;
    }
}

?>
