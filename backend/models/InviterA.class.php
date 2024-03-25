<?php

class InviterA {
    private $id_utilisateur_invitant_evt;
    private $id_utilisateur_invite_evt;
    private $id_evenement_invitation;

    public function __construct($id_utilisateur_invitant_evt, $id_utilisateur_invite_evt, $id_evenement_invitation) {
        $this->id_utilisateur_invitant_evt = $id_utilisateur_invitant_evt;
        $this->id_utilisateur_invite_evt = $id_utilisateur_invite_evt;
        $this->id_evenement_invitation = $id_evenement_invitation;
    }

    public function getIdUtilisateurInvitantEvt() {
        return $this->id_utilisateur_invitant_evt;
    }

    public function getIdUtilisateurInviteEvt() {
        return $this->id_utilisateur_invite_evt;
    }

    public function getIdEvenementInvitation() {
        return $this->id_evenement_invitation;
    }
}

?>
