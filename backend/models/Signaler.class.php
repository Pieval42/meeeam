<?php

class Signaler {
    private $id_utilisateur_signalant;
    private $id_utilisateur_signale;

    public function __construct($id_utilisateur_signalant, $id_utilisateur_signale) {
        $this->id_utilisateur_signalant = $id_utilisateur_signalant;
        $this->id_utilisateur_signale = $id_utilisateur_signale;
    }

    public function getIdUtilisateurSignalant() {
        return $this->id_utilisateur_signalant;
    }

    public function getIdUtilisateurSignale() {
        return $this->id_utilisateur_signale;
    }
}

?>
