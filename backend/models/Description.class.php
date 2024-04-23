<?php

/**
 * Représentation de la table SQL `description`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Description {
    private $id_utilisateur_description;
    private $id_description;
    private $contenu_description;

    public function __construct($id_utilisateur_description, $id_description, $contenu_description) {
        $this->id_utilisateur_description = $id_utilisateur_description;
        $this->id_description = $id_description;
        $this->contenu_description = $contenu_description;
    }

    public function getIdUtilisateurDescription() {
        return $this->id_utilisateur_description;
    }

    public function setIdUtilisateurDescription($id_utilisateur_description) {
        $this->id_utilisateur_description = $id_utilisateur_description;
    }

    public function getIdDescription() {
        return $this->id_description;
    }

    public function setIdDescription($id_description) {
        $this->id_description = $id_description;
    }

    public function getContenuDescription() {
        return $this->contenu_description;
    }

    public function setContenuDescription($contenu_description) {
        $this->contenu_description = $contenu_description;
    }
}
?>
