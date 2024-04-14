<?php

require_once __DIR__ . "/../" . 'Model.class.php';
require_once __DIR__ . "/../" . 'Ville.class.php';

class VilleManager extends Model
{
    private $ville;

    private function creerObjetVille($ville)
    {
        $this->ville = new Ville(
            $ville['id_ville'],
            $ville['nom_ville'],
            $ville['code_postal'],
            $ville['id_pays_ville']
        );
    }

    public function getVille($nom_ville, $code_postal)
    {
        $req = "
            SELECT * FROM ville
            WHERE nom_ville = :nom_ville AND code_postal = :code_postal
        ";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':nom_ville', $nom_ville, PDO::PARAM_STR);
        $stmt->bindValue(':code_postal', $code_postal, PDO::PARAM_INT);
        $stmt->execute();
        $ville = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if ($ville) {
            $this->creerObjetVille($ville);
            return $this->ville;
        } else {
            return null;
        }
    }

    public function getAllVilles($limit = null)
    {
        $req = "
            SELECT * FROM ville
            ORDER BY nom_ville ASC
        ";
        if ($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $villes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $allVilles = [];

        if ($villes) {
            foreach ($villes as $ville) {
                $this->creerObjetVille($ville);
                $allVilles[] = $this->ville;
            }
        }
        return $allVilles;
    }

    public function creerVille($nom_ville, $code_postal, $id_pays_ville)
    {
        $req = "
            INSERT INTO ville
            (nom_ville, code_postal, id_pays_ville)
            VALUES (:nom_ville, :code_postal, :id_pays_ville)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':nom_ville', $nom_ville, PDO::PARAM_STR);
        $stmt->bindValue(':code_postal', $code_postal, PDO::PARAM_INT);
        $stmt->bindValue(':id_pays_ville', $id_pays_ville, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        $ville = $this->getVille($nom_ville, $code_postal);
        if ($ville) {
            return $ville;
        } else {
            return null;
        }
    }

    public function getVilleById($id)
    {
        $req = "SELECT * FROM ville WHERE id_ville = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $ville = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if ($ville) {
            $this->creerObjetVille($ville);
            return $this->ville;
        } else {
            return null;
        }
    }

    public function updateVille($id_ville, $nom_ville, $code_postal, $id_pays_ville)
    {
        $req = "
            UPDATE ville
            SET pseudo_ville = :pseudo, nom_ville = :nom_ville, code_postal = :code_postal, id_pays_ville = :id_pays_ville
            WHERE id_ville = :id_ville
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_ville', $id_ville, PDO::PARAM_INT);
        $stmt->bindValue(':nom_ville', $nom_ville, PDO::PARAM_STR);
        $stmt->bindValue(':code_postal', $code_postal, PDO::PARAM_INT);
        $stmt->bindValue(':id_pays_ville', $id_pays_ville, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteVille($id)
    {
        $req = "DELETE FROM ville WHERE id_ville = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
