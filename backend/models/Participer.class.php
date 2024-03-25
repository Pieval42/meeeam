<?php

class Participer {
    private $id_utilisateur_participant;
    private $id_evenement_participant;

    public function __construct($id_utilisateur_participant, $id_evenement_participant) {
        $this->id_utilisateur_participant = $id_utilisateur_participant;
        $this->id_evenement_participant = $id_evenement_participant;
    }

    public function getIdUtilisateurParticipant() {
        return $this->id_utilisateur_participant;
    }

    public function getIdEvenementParticipant() {
        return $this->id_evenement_participant;
    }
}

?>
