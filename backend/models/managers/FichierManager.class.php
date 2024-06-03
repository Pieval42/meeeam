<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../Fichier.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `fichier`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class FichierManager extends Model
{
  /**
   * Objet représentant un fichier
   *
   * @var object
   */
  private $fichier;

  /**
   * Tableau de fichiers
   *
   * @var array
   */
  private $listeFichiers;

  /**
   * Crée un attribut fichier
   *
   * @param  object $fichier
   * 
   * @return void
   */
  public function ajoutFichier($fichier)
  {
    $this->fichier = $fichier;
    $this->listeFichiers[] = $fichier;
  }

  /**
   * Récupère la liste de tous les fichiers d'un utilisateur
   *
   * @param  int $idUtilisateur
   * @param  int $limit option pour limiter le nombre de résultats
   * 
   * @return array Tableau contenant tous les fichiers.
   */
  public function getAllFichiers($idUtilisateur, $limit = null)
  {
    $req =
      "SELECT * FROM fichier
        WHERE id_utilisateur_fichier = :idUtilisateur";
    if ($limit) {
      $req .= " LIMIT :limit";
    }
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":idUtilisateur", $idUtilisateur, PDO::PARAM_INT);
    if ($limit) {
      $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    $fichiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($fichiers as $fichier) {
      $f = new Fichier(
        $fichier["id_fichier"],
        $fichier["nom_fichier"],
        $fichier["id_type_fichier_fk"],
        $fichier["id_utilisateur_fichier"],
        $fichier["url_fichier"]
      );
      $this->ajoutFichier($f);
    }
    return $fichiers;
  }

  /**
   * Crée un fichier.
   * 
   * @param  int     $idFichier
   * @param  string  $nomFichier
   * @param  int     $idTypeFichier
   * @param  int     $idUtilisateur
   * 
   * @return void
   */
  public function creerFichier(
    $idFichier,
    $nomFichier,
    $idTypeFichier,
    $idUtilisateur,
    $urlFichier
  ) {
    $req =
      "INSERT INTO fichier
        (id_fichier, nom_fichier, id_type_fichier_fk, id_utilisateur_fichier, url_fichier)
        VALUES (:idFichier, :nomFichier, :idTypeFichier, :idUtilisateur, :urlFichier)";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":idFichier", $idFichier, PDO::PARAM_STR);
    $stmt->bindValue(":nomFichier", $nomFichier, PDO::PARAM_STR);
    $stmt->bindValue(":idTypeFichier", $idTypeFichier, PDO::PARAM_STR);
    $stmt->bindValue(":idUtilisateur", $idUtilisateur, PDO::PARAM_INT);
    $stmt->bindValue(":urlFichier", $urlFichier, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
  }

  /**
   * Récupère un fichier grâce à son identifiant.
   *
   * @param  int  $id
   * 
   * @return object  Objet représentant le fichier trouvé.
   */
  public function getFichierById($id)
  {
    $req = "SELECT * FROM fichier WHERE id_fichier = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $fichier = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return new Fichier(
      $fichier["id_fichier"],
      $fichier["nom_fichier"],
      $fichier["id_type_fichier_fk"],
      $fichier["id_utilisateur_fichier"],
      $fichier["url_fichier"]
    );
  }

  

  /**
   * Supprime un fichier.
   *
   * @param  int  $id
   * 
   * @return void
   */
  public function deleteFichier($id)
  {
    $req = "DELETE FROM fichier WHERE id_fichier = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }
}
