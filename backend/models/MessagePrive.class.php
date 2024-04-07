<?php

class MessagePrive {
    private $id_expediteur_prive;
    private $id_message_prive;
    private $contenu_message;
    private $date_heure_message;
    private $id_groupe_discussion_message_prive;
    private $id_destinataire_prive;

    public function __construct($id_message_prive, $id_expediteur_prive, $contenu_message, $date_heure_message, $id_destinataire_prive, $id_groupe_discussion_message_prive) {
        $this->id_message_prive = $id_message_prive;
        $this->id_expediteur_prive = $id_expediteur_prive;
        $this->contenu_message = $contenu_message;
        $this->date_heure_message = $date_heure_message;
        $this->id_destinataire_prive = $id_destinataire_prive;
        $this->id_groupe_discussion_message_prive = $id_groupe_discussion_message_prive;
    }

    public function getIdExpediteurPrive() {
        return $this->id_expediteur_prive;
    }

    public function getIdMessagePrive() {
        return $this->id_message_prive;
    }

    public function getContenuMessage() {
        return $this->contenu_message;
    }

    public function setContenuMessage($contenu_message) {
        $this->contenu_message = $contenu_message;
    }

    public function getDateHeureMessage() {
        return $this->date_heure_message;
    }

    public function getIdGroupeDiscussionMessagePrive() {
        return $this->id_groupe_discussion_message_prive;
    }

    public function getIdDestinatairePrive() {
        return $this->id_destinataire_prive;
    }
}

?>
