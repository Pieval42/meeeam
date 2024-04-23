<?php

/**
 * Représentation de la table SQL `message_public`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class MessagePublic {
    private $id_expediteur_public;
    private $id_message_public;
    private $objet_message_public;
    private $contenu_message_public;
    private $date_heure_msg_pub;
    private $id_destinataire_public;
    private $id_page_profil_msg_pub;

    public function __construct($id_expediteur_public, $id_message_public, $objet_message_public, $contenu_message_public, $date_heure_msg_pub, $id_destinataire_public, $id_page_profil_msg_pub) {
        $this->id_expediteur_public = $id_expediteur_public;
        $this->id_message_public = $id_message_public;
        $this->objet_message_public = $objet_message_public;
        $this->contenu_message_public = $contenu_message_public;
        $this->date_heure_msg_pub = $date_heure_msg_pub;
        $this->id_destinataire_public = $id_destinataire_public;
        $this->id_page_profil_msg_pub = $id_page_profil_msg_pub;
    }

    public function getIdExpediteurPublic() {
        return $this->id_expediteur_public;
    }

    public function setIdExpediteurPublic($id_expediteur_public) {
        $this->id_expediteur_public = $id_expediteur_public;
    }

    public function getIdMessagePublic() {
        return $this->id_message_public;
    }

    public function setIdMessagePublic($id_message_public) {
        $this->id_message_public = $id_message_public;
    }

    public function getObjetMessagePublic() {
        return $this->objet_message_public;
    }

    public function setObjetMessagePublic($objet_message_public) {
        $this->objet_message_public = $objet_message_public;
    }

    public function getContenuMessagePublic() {
        return $this->contenu_message_public;
    }

    public function setContenuMessagePublic($contenu_message_public) {
        $this->contenu_message_public = $contenu_message_public;
    }

    public function getDateHeureMsgPub() {
        return $this->date_heure_msg_pub;
    }

    public function setDateHeureMsgPub($date_heure_msg_pub) {
        $this->date_heure_msg_pub = $date_heure_msg_pub;
    }

    public function getIdDestinatairePublic() {
        return $this->id_destinataire_public;
    }

    public function setIdDestinatairePublic($id_destinataire_public) {
        $this->id_destinataire_public = $id_destinataire_public;
    }

    public function getIdPageProfilMsgPub() {
        return $this->id_page_profil_msg_pub;
    }

    public function setIdPageProfilMsgPub($id_page_profil_msg_pub) {
        $this->id_page_profil_msg_pub = $id_page_profil_msg_pub;
    }
}
?>
