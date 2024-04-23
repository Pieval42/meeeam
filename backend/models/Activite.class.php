<?php

/**
 * Représentation de la table SQL `activite`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Activite {
    private $id_activite;
    private $libelle_activite;

    public function __construct($id_activite, $libelle_activite) {
        $this->id_activite = $id_activite;
        $this->libelle_activite = $libelle_activite;
    }

    public function getIdActivite() {
        return $this->id_activite;
    }

    public function setIdActivite($id_activite) {
        $this->id_activite = $id_activite;
    }

    public function getLibelleActivite() {
        return $this->libelle_activite;
    }

    public function setLibelleActivite($libelle_activite) {
        $this->libelle_activite = $libelle_activite;
    }
}
?>
