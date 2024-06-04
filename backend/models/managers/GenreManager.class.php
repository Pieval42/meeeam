<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../Genre.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `genre`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class GenreManager extends Model
{
  /**
   * Récupère un genre grâce à son identifiant.
   *
   * @param  string  $id
   * 
   * @return string  Libellé du genre.
   */
  public function getGenreById($id)
  {
    $req = "SELECT * FROM genre WHERE id_genre = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_STR);
    $stmt->execute();
    $genre = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if(isset($genre["libelle_genre"])) {
      return $genre["libelle_genre"];
    }
    return false;
  }
}
