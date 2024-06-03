<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../Lister.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `lister`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class ListerManager extends Model
{
  private $lister;

  /**
   * Créé un objet représentant une ligne de la table `lister`
   *
   * @param  array $correspondance
   * 
   * @return void
   */
  private function creerObjetLister($correspondance)
  {
    $this->lister = new Lister(
      $correspondance["id_utilisateur_site_web"],
      $correspondance["adresse_site_web_liste"]
    );
  }

  /**
   * Récupère un site web d'un utilisateur
   *
   * @param int     $id_utilisateur_site_web
   * @param string  $adresse_site_web_liste
   * 
   * @return object|null Objet représentant la ligne de la table `lister`
   *                     correspondante.
   */
  public function getCorrespondance(
    $id_utilisateur_site_web,
    $adresse_site_web_liste
  ) {
    $req =
      "SELECT * FROM lister
        WHERE id_utilisateur_site_web = :id_utilisateur_site_web
        AND adresse_site_web_liste = :adresse_site_web_liste";

    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":id_utilisateur_site_web",
      $id_utilisateur_site_web,
      PDO::PARAM_INT
    );
    $stmt->bindValue(
      ":adresse_site_web_liste",
      $adresse_site_web_liste,
      PDO::PARAM_STR
    );
    $stmt->execute();
    $correspondance = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    if ($correspondance) {
      $this->creerObjetLister($correspondance);
      return $this->lister;
    } else {
      return null;
    }
  }

  /**
   * Récupère la liste de tous les sites web d'un utilisateur
   *
   * @param int $id_utilisateur_site_web
   * @param int $limit
   * 
   * @return array Tableau d'objets représentant les lignes de la table `lister`
   *               correspondantes.
   */
  public function getAllSitesByUtilisateur(
    $id_utilisateur_site_web,
    $limit = null
  ) {
    $req =
      "SELECT * FROM lister
        WHERE id_utilisateur_site_web = :id_utilisateur_site_web
        ORDER BY adresse_site_web_liste ASC";
    if ($limit) {
      $req .= " LIMIT :limit";
    }
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":id_utilisateur_site_web",
      $id_utilisateur_site_web,
      PDO::PARAM_INT
    );
    if ($limit) {
      $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    $liste = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $liste;
  }

  /**
   * Créé une correspondance entre un site web et un utilisateur
   *
   * @param int     $id_utilisateur_site_web
   * @param string  $adresse_site_web_liste
   * 
   * @return object|null Objet représentant la ligne de la table `lister`
   *                     créée.
   */
  public function creerCorrespondance(
    $id_utilisateur_site_web,
    $adresse_site_web_liste
  ) {
    $req =
      "INSERT INTO lister (id_utilisateur_site_web, adresse_site_web_liste)
        VALUES (:id_utilisateur_site_web, :adresse_site_web_liste)";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":id_utilisateur_site_web",
      $id_utilisateur_site_web,
      PDO::PARAM_INT
    );
    $stmt->bindValue(
      ":adresse_site_web_liste",
      $adresse_site_web_liste,
      PDO::PARAM_STR
    );
    $stmt->execute();
    $stmt->closeCursor();
    $correspondance = $this->getCorrespondance(
      $id_utilisateur_site_web,
      $adresse_site_web_liste
    );
    if ($correspondance) {
      return $correspondance;
    } else {
      return null;
    }
  }

  /**
   * deleteCorrespondance
   *
   * @param int     $id_utilisateur_site_web
   * @param string  $adresse_site_web_liste
   * 
   * @return void
   */
  public function deleteCorrespondance(
    $id_utilisateur_site_web,
    $adresse_site_web_liste
  ) {
    $req =
      "DELETE FROM lister
        WHERE id_utilisateur_site_web = :id_utilisateur_site_web
        AND adresse_site_web_liste = :adresse_site_web_liste";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":id_utilisateur_site_web",
      $id_utilisateur_site_web,
      PDO::PARAM_INT
    );
    $stmt->bindValue(
      ":adresse_site_web_liste",
      $adresse_site_web_liste,
      PDO::PARAM_STR
    );
    $stmt->execute();
    $stmt->closeCursor();
  }
}
?>
