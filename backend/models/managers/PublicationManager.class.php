<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../Publication.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `publication`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class PublicationManager extends Model
{
  /**
   * Objet représentant une publication
   *
   * @var object
   */
  private $publication;

  /**
   * Tableau de publications
   *
   * @var array
   */
  private $listePublications;

  /**
   * Crée un attribut publication
   *
   * @param  object $publication
   * 
   * @return void
   */
  public function ajoutPublication($publication)
  {
    $this->publication = $publication;
    $this->listePublications[] = $publication;
  }

  /**
   * Récupère la liste de toutes les publications d'un utilisateur
   *
   * @param  int $limit option pour limiter le nombre de résultats
   * 
   * @return array Tableau contenant toutes les publications.
   */
  public function getAllPublications($idUtilisateur, $idPageProfil, $limit = null)
  {
    $req =
      "SELECT * FROM publication
        WHERE id_createur_publication = :idUtilisateur
        AND id_page_profil_publication = :idPageProfil
        ORDER BY date_heure_publication ASC";
    if ($limit) {
      $req .= " LIMIT :limit";
    }
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":idUtilisateur", $idUtilisateur, PDO::PARAM_INT);
    $stmt->bindValue(":idPageProfil", $idPageProfil, PDO::PARAM_INT);
    if ($limit) {
      $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($publications as $publication) {
      $p = new Publication(
        $publication["id_publication"],
        $publication["contenu_publication"],
        $publication["date_heure_publication"],
        $publication["id_type_fichier_publication"],
        $publication["id_fichier_publication"],
        $publication["id_page_publique_publication"],
        $publication["id_page_profil_publication"],
        $publication["id_utilisateur_page_profil"],
        $publication["id_genre_publication"],
        $publication["id_createur_publication"]
      );
      $this->ajoutPublication($p);
    }
    return $publications;
  }

  /**
   * Recherche une publication à partir d'une chaîne de caractères.
   *
   * @param  string $search
   * 
   * @return array Tableau contenant les publications correspondantes.
   */
  public function searchPublications($search)
  {
    $search .= "%";
    $req =
      "SELECT * FROM publication
        WHERE contenu_publication IN :search
        ORDER BY date_heure_publication ASC";
    $stmt = $this->getBdd()->prepare($req);

    $stmt->bindValue(":search", $search, PDO::PARAM_STR);
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($publications as $publication) {
      $p = new Publication(
        $publication["id_publication"],
        $publication["contenu_publication"],
        $publication["date_heure_publication"],
        $publication["id_type_fichier_publication"],
        $publication["id_fichier_publication"],
        $publication["id_page_publique_publication"],
        $publication["id_page_profil_publication"],
        $publication["id_utilisateur_page_profil"],
        $publication["id_genre_publication"],
        $publication["id_createur_publication"]
      );
      $this->ajoutPublication($p);
    }
    return $publications;
  }

  /**
   * Crée une publication.
   * 
   * @param  string  $contenu
   * @param  int     $idTypeFichier
   * @param  int     $idFichier
   * @param  int     $idPagePublique
   * @param  int     $idPageProfil
   * @param  int     $idUtilisateurPageProfil
   * @param  int     $idCreateurPublication
   * 
   * @return void
   */
  public function creerPublication(
    $contenu,
    $idTypeFichier = null,
    $idFichier = null,
    $idPagePublique = null,
    $idPageProfil = null,
    $idUtilisateurPageProfil = null,
    $idCreateurPublication,
  ) {
    $req =
      "INSERT INTO publication
        (contenu_publication, id_type_fichier_publication, id_fichier_publication, id_page_publique_publication, id_page_profil_publication, id_utilisateur_page_profil, id_createur_publication)
        VALUES (:contenu, :idTypeFichier, :idFichier, :idPagePublique, :idPageProfil, :idUtilisateurPageProfil, :idCreateurPublication)";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":contenu", $contenu, PDO::PARAM_STR);
    $stmt->bindValue(":idTypeFichier", $idTypeFichier, PDO::PARAM_INT);
    $stmt->bindValue(":idFichier", $idFichier, PDO::PARAM_INT);
    $stmt->bindValue(":idPagePublique", $idPagePublique, PDO::PARAM_INT);
    $stmt->bindValue(":idPageProfil", $idPageProfil, PDO::PARAM_INT);
    $stmt->bindValue(":idUtilisateurPageProfil", $idUtilisateurPageProfil, PDO::PARAM_INT);
    $stmt->bindValue(":idCreateurPublication", $idCreateurPublication, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }

  /**
   * Récupère une publication grâce à son identifiant.
   *
   * @param  int  $id
   * 
   * @return object  Objet représentant la publication trouvée.
   */
  public function getPublicationById($id)
  {
    $req = "SELECT * FROM publication WHERE id_publication = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $publication = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return new Publication(
      $publication["id_publication"],
      $publication["contenu_publication"],
      $publication["date_heure_publication"],
      $publication["id_type_fichier_publication"],
      $publication["id_fichier_publication"],
      $publication["id_page_publique_publication"],
      $publication["id_page_profil_publication"],
      $publication["id_utilisateur_page_profil"],
      $publication["id_genre_publication"],
      $publication["id_createur_publication"]
    );
  }

  
  public function updatePublication(
    $id,
    $contenu,
    $idTypeFichier = null,
    $idFichier = null,
  ) {
    $req =
      "UPDATE publication
        SET contenu_publication = :contenu, id_type_fichier_publication  = :idTypeFichier, id_fichier_publication = :idFichier
        WHERE id_publication = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":contenu", $contenu, PDO::PARAM_STR);
    $stmt->bindValue(":idTypeFichier", $idTypeFichier, PDO::PARAM_INT);
    $stmt->bindValue(":idFichier", $idFichier, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }

  /**
   * Supprime une publication.
   *
   * @param  int  $id
   * 
   * @return void
   */
  public function deletePublication($id)
  {
    $req = "DELETE FROM publication WHERE id_publication = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }
}
