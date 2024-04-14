<?php

require_once __DIR__ . "/../" . 'Model.class.php';
require_once __DIR__ . "/../" . 'MessagePrive.class.php';

class MessagePriveManager extends Model {
    private $message_prive;
    
    public function ajoutMessagePrive($message_prive){
        $this->message_prive = $message_prive;
    }
    
    public function getMessagePrive(){
        return $this->message_prive;
    }

    public function getAllMessagePrives($id_utilisateur, $limit = null) {
        $req = "
            SELECT * FROM message_prive
            WHERE id_expediteur_prive = :id_utilisateur OR id_destinataire_prive = :id_utilisateur
            ORDER BY date_heure_message DESC
        ";
        if($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        if($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $message_prives = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $message_prives;
    }

    public function getLastMessagePrive() {
        $req = "
            SELECT * FROM message_prive
            ORDER BY id_message_prive DESC
            LIMIT 1
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $message_prive = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
            
        return new MessagePrive(
            $message_prive['id_message_prive'],
            $message_prive['contenu_message'],
            $message_prive['date_heure_message'],
            $message_prive['id_expediteur_prive'],
            $message_prive['id_groupe_discussion_message_prive'],
            $message_prive['id_destinataire_prive'],
        );
        
    }

    public function getConversation($id_utilisateur,  $id_utilisateur_2, $limit = null) {
        $req = "
            SELECT * FROM message_prive
            WHERE (id_expediteur_prive = :id_utilisateur OR id_destinataire_prive = :id_utilisateur) AND (id_expediteur_prive = :id_utilisateur_2 OR id_destinataire_prive = :id_utilisateur_2)
            ORDER BY date_heure_message ASC
        ";
        if($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->bindValue(':id_utilisateur_2', $id_utilisateur_2, PDO::PARAM_INT);
        if($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $message_prives = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $message_prives;
    }
    
    public function creerMessagePrive($id_expediteur_prive, $contenu_message, $id_destinataire_prive, $id_groupe_discussion_message_prive = null) {
        $req = "
            INSERT INTO message_prive
            (id_expediteur_prive, contenu_message, id_destinataire_prive, id_groupe_discussion_message_prive)
            VALUES (:id_expediteur_prive, :contenu_message, :id_destinataire_prive, :id_groupe_discussion_message_prive)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_expediteur_prive', $id_expediteur_prive,PDO::PARAM_INT);
        $stmt->bindValue(':contenu_message', $contenu_message, PDO::PARAM_STR);
        $stmt->bindValue(':id_destinataire_prive', $id_destinataire_prive, PDO::PARAM_INT);
        $stmt->bindValue(':id_groupe_discussion_message_prive', $id_groupe_discussion_message_prive, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        $message_prive = $this->getLastMessagePrive();
        $id_message_prive = $message_prive->getIdMessagePrive();
        $date_heure_message = $message_prive->getDateHeureMessage();
        return new MessagePrive($id_message_prive, $id_expediteur_prive, $contenu_message, $date_heure_message, $id_destinataire_prive, $id_groupe_discussion_message_prive);
    }

    public function deleteMessagePrive($id_message_prive) {
        $req = "DELETE FROM message_prive WHERE id_message_prive = :id_message_prive";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_message_prive', $id_message_prive, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
}

?>
