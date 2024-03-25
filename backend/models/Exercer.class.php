<?php

class Exercer {
    private $id_utilisateur_activite;
    private $id_activite;

    public function __construct($id_utilisateur_activite, $id_activite) {
        $this->id_utilisateur_activite = $id_utilisateur_activite;
        $this->id_activite = $id_activite;
    }

    public function getIdUtilisateurActivite() {
        return $this->id_utilisateur_activite;
    }

    public function getIdActivite() {
        return $this->id_activite;
    }
}

?>
