<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../SiteWeb.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `site_web`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class SiteWebManager extends Model
{
  /**
   * Objet représentant un site web
   *
   * @var object
   */
  private $site_web;

  /**
   * Crée un objet représentant un site web et le stocke dans l'attribut $site_web
   *
   * @param  string $site_web
   * 
   * @return void
   */
  private function creerObjetSiteWeb($site_web)
  {
    $this->site_web = new SiteWeb($site_web["adresse_site_web"]);
  }

  /**
   * Récupère un site web grâce à son adresse
   *
   * @param  string  $adresse_site_web
   * 
   * @return object Objet représentant un site web
   */
  public function getSiteWeb($adresse_site_web)
  {
    $req =
      "SELECT * FROM site_web
          WHERE adresse_site_web = :adresse_site_web";

    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":adresse_site_web",
      $adresse_site_web,
      PDO::PARAM_STR
    );
    $stmt->execute();
    $site_web = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    if ($site_web) {
      $this->creerObjetSiteWeb($site_web);
      return $this->site_web;
    } else {
      return null;
    }
  }

  /**
   * Récupère tous les sites web présents dans la BDD
   *
   * @param  int $limit option pour limiter le nombre de résultats
   * 
   * @return array Tableau d'objets représentant les sites web trouvés.
   */
  public function getAllSiteWebs($limit = null)
  {
    $req =
      "SELECT * FROM site_web
            ORDER BY adresse_site_web ASC";

    if ($limit) {
      $req .= " LIMIT :limit";
    }
    $stmt = $this->getBdd()->prepare($req);
    if ($limit) {
      $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    $site_webs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    $allSiteWebs = [];

    if ($site_webs) {
      foreach ($site_webs as $site_web) {
        $this->creerObjetSiteWeb($site_web);
        $allSiteWebs[] = $this->site_web;
      }
    }
    return $allSiteWebs;
  }

  /**
   * Crée un site web s'il n'existe pas déjà dans la BDD
   *
   * @param  string $adresse_site_web
   * 
   * @return object|null Objet représentant un site web s'il existe, null sinon.
   */
  public function creerSiteWeb($adresse_site_web)
  {
    if ($adresse_site_web === "") return;
    //  Vérification de l'existence ou non du site web dans la BDD
    $site_web_existant = $this->getSiteWeb($adresse_site_web);
    if ($site_web_existant) {
      return $site_web_existant->getAdresseSiteWeb() ===
        $adresse_site_web && $site_web_existant;
    }
    $req =
      "INSERT INTO site_web (adresse_site_web)
            VALUES (:adresse_site_web)";

    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":adresse_site_web",
      $adresse_site_web,
      PDO::PARAM_STR
    );
    $stmt->execute();
    $stmt->closeCursor();
    $site_web = $this->getSiteWeb($adresse_site_web);
    if ($site_web) {
      return $site_web;
    } else {
      return null;
    }
  }

  /**
   * Supprime un site web
   *
   * @param  string $adresse_site_web
   * 
   * @return void
   */
  public function deleteSiteWeb($adresse_site_web)
  {
    $req = "DELETE FROM site_web WHERE adresse_site_web = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(
      ":adresse_site_web",
      $adresse_site_web,
      PDO::PARAM_STR
    );
    $stmt->execute();
    $stmt->closeCursor();
  }
}
?>
