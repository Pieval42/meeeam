<?php

require_once __DIR__ . "/../" . 'Model.class.php';
require_once __DIR__ . "/../" . 'Pays.class.php';

class PaysManager extends Model
{
    private $pays;

    public function ajoutPays($pays)
    {
        $this->pays[] = $pays;
    }

    public function getPays($id_pays)
    {
        $req = "
            SELECT * FROM pays
            WHERE id_pays = :id_pays
        ";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_pays', $id_pays, PDO::PARAM_STR);
        $stmt->execute();
        $pays = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return new Pays(
            $pays['id_pays'],
            $pays['code_pays'],
            $pays['nom_fr'],
            $pays['nom_en']
        );
    }

    public function getAllPays($limit = null)
    {
        $req = "
            SELECT * FROM pays
            ORDER BY nom_fr ASC
        ";
        if ($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $liste_pays = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($liste_pays as $pays) {
            $p = new Pays(
                $pays['id_pays'],
                $pays['code_pays'],
                $pays['nom_fr'],
                $pays['nom_en']
            );
            $this->ajoutPays($p);
        }
        return $liste_pays;
    }
}