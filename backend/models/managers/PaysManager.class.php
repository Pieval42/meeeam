<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../Pays.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `pays`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class PaysManager extends Model
{    
    /**
     * Tableau d'objets représentant des pays
     *
     * @var array
     */
    private $pays;
    
    /**
     * Ajoute un pays au tableau $pays
     *
     * @param  object $pays
     * 
     * @return void
     */
    public function ajoutPays($pays)
    {
        $this->pays[] = $pays;
    }
    
    /**
     * Récupère un pays grâce à son identifiant numérique
     *
     * @param  int $id_pays
     * 
     * @return object Objet représentant le pays correspondant.
     */
    public function getPays($id_pays)
    {
        $req =
        "SELECT * FROM pays
          WHERE id_pays = :id_pays";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_pays", $id_pays, PDO::PARAM_STR);
        $stmt->execute();
        $pays = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return new Pays(
            $pays["id_pays"],
            $pays["code_pays"],
            $pays["nom_fr"],
            $pays["nom_en"]
        );
    }
    
    /**
     * Récupère la liste de tous les pays
     *
     * @param  int $limit option pour limiter le nombre de résultats
     * 
     * @return array Tableau d'objets représentant tous les pays
     */
    public function getAllPays($limit = null)
    {
        $req =
        "SELECT * FROM pays
          ORDER BY id_pays ASC";
          
        if ($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        if ($limit) {
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $liste_pays = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($liste_pays as $pays) {
            $p = new Pays(
                $pays["id_pays"],
                $pays["code_pays"],
                $pays["nom_fr"],
                $pays["nom_en"]
            );
            $this->ajoutPays($p);
        }
        return $liste_pays;
    }
}
?>
