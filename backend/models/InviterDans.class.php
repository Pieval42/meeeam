<?php

class InviterDans {
    private $id_utilisateur_invitant_grp;
    private $id_utilisateur_invite_grp;
    private $id_groupe_discussion_invitation;

    public function __construct($id_utilisateur_invitant_grp, $id_utilisateur_invite_grp, $id_groupe_discussion_invitation) {
        $this->id_utilisateur_invitant_grp = $id_utilisateur_invitant_grp;
        $this->id_utilisateur_invite_grp = $id_utilisateur_invite_grp;
        $this->id_groupe_discussion_invitation = $id_groupe_discussion_invitation;
    }

    public function getIdUtilisateurInvitantGrp() {
        return $this->id_utilisateur_invitant_grp;
    }

    public function getIdUtilisateurInviteGrp() {
        return $this->id_utilisateur_invite_grp;
    }

    public function getIdGroupeDiscussionInvitation() {
        return $this->id_groupe_discussion_invitation;
    }
}

?>
