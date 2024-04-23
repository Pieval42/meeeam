<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../MessagePrive.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `message_prive`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class MessagePriveManager extends Model
{
  /**
   * Récupère tous les messages d'un utiisateur dont il est soit l'expéditeur soit le destinataire
   *
   * @param  int $id_utilisateur
   * @param  int $limit
   * 
   * @return array Tableau contenant tous les messages correspondants.
   */
  public function getAllMessagePrives($id_utilisateur, $limit = null)
  {
    $req =
      "SELECT * FROM message_prive
        WHERE id_expediteur_prive = :id_utilisateur OR id_destinataire_prive = :id_utilisateur
        ORDER BY date_heure_message DESC";
    if ($limit) {
      $req .= " LIMIT :limit";
    }
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
    if ($limit) {
      $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    $message_prives = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $message_prives;
  }

  /**
   * Récupère le dernier message privé d'un expéditeur
   *
   * @return object Objet représentant le message correspondant.
   */
  public function getLastMessagePrive($id_expediteur_prive)
  {
    $req =
      "SELECT * FROM message_prive
        WHERE id_expediteur_prive = :id_expediteur_prive
        ORDER BY id_message_prive DESC
        LIMIT 1";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":id_expediteur_prive",
      $id_expediteur_prive,
      PDO::PARAM_INT
    );
    $stmt->execute();
    $message_prive = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return new MessagePrive(
      $message_prive["id_message_prive"],
      $message_prive["contenu_message"],
      $message_prive["date_heure_message"],
      $message_prive["id_expediteur_prive"],
      $message_prive["id_groupe_discussion_message_prive"],
      $message_prive["id_destinataire_prive"]
    );
  }

  /**
   * Récupère tous les messages d'une conversation entre deux utilisateurs
   *
   * @param  int $id_utilisateur
   * @param  int $id_utilisateur_2
   * @param  int $limit
   * 
   * @return array Tableau contenant tous les messages correspondants.
   */
  public function getConversation(
    $id_utilisateur,
    $id_utilisateur_2,
    $limit = null
  ) {
    $req =
      "SELECT * FROM message_prive
        WHERE (id_expediteur_prive = :id_utilisateur OR id_destinataire_prive = :id_utilisateur) AND (id_expediteur_prive = :id_utilisateur_2 OR id_destinataire_prive = :id_utilisateur_2)
        ORDER BY date_heure_message ASC";
    if ($limit) {
      $req .= " LIMIT :limit";
    }
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
    $stmt->bindValue(
      ":id_utilisateur_2",
      $id_utilisateur_2,
      PDO::PARAM_INT
    );
    if ($limit) {
      $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    $message_prives = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $message_prives;
  }

  /**
   * Créé un message privé entre deux correspondants
   *
   * @param  int    $id_expediteur_prive
   * @param  string $contenu_message
   * @param  int    $id_destinataire_prive
   * @param  int    $id_groupe_discussion_message_prive
   * 
   * @return object Objet représentant le message créé.
   */
  public function creerMessagePrive(
    $id_expediteur_prive,
    $contenu_message,
    $id_destinataire_prive,
    $id_groupe_discussion_message_prive = null
  ) {
    $req =
      "INSERT INTO message_prive (id_expediteur_prive, contenu_message, id_destinataire_prive, id_groupe_discussion_message_prive)
        VALUES (:id_expediteur_prive, :contenu_message, :id_destinataire_prive, :id_groupe_discussion_message_prive)";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":id_expediteur_prive",
      $id_expediteur_prive,
      PDO::PARAM_INT
    );
    $stmt->bindValue(":contenu_message", $contenu_message, PDO::PARAM_STR);
    $stmt->bindValue(
      ":id_destinataire_prive",
      $id_destinataire_prive,
      PDO::PARAM_INT
    );
    $stmt->bindValue(
      ":id_groupe_discussion_message_prive",
      $id_groupe_discussion_message_prive,
      PDO::PARAM_INT
    );
    $stmt->execute();
    $stmt->closeCursor();
    $message_prive = $this->getLastMessagePrive($id_expediteur_prive);
    $id_message_prive = $message_prive->getIdMessagePrive();
    $date_heure_message = $message_prive->getDateHeureMessage();
    return new MessagePrive(
      $id_message_prive,
      $id_expediteur_prive,
      $contenu_message,
      $date_heure_message,
      $id_destinataire_prive,
      $id_groupe_discussion_message_prive
    );
  }

  /**
   * Supprime un message privé
   *
   * @param  int $id_message_prive
   * 
   * @return void
   */
  public function deleteMessagePrive($id_message_prive)
  {
    $req =
      "DELETE FROM message_prive
        WHERE id_message_prive = :id_message_prive";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":id_message_prive",
      $id_message_prive,
      PDO::PARAM_INT
    );
    $stmt->execute();
    $stmt->closeCursor();
  }
}
?>
