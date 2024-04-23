<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../PageProfil.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `page_profil`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class PageProfilManager extends Model
{
  /**
   * Récupère l'id de la page de profil correspondant à l'utilisateur
   *
   * @param  int $id_utilisateur
   * 
   * @return int Id de la page de profil correspondante.
   */
  public function getPageProfilByIdUtilisateur($id_utilisateur)
  {
    $req =
      "SELECT * FROM page_profil
        WHERE id_utilisateur_page_profil = :id_utilisateur";

    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $res["id_page_profil"];
  }
  
  /**
   * Créé une page de profil liée à un utilisateur
   *
   * @param  int $id_utilisateur
   * 
   * @return void
   */
  public function creerPageProfil($id_utilisateur)
  {
    $req = "   INSERT INTO page_profil
                  (id_utilisateur_page_profil)
                  VALUES (:id_utilisateur)
              ";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }
}
?>
