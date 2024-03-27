<?php

require_once 'Model.class.php';
require_once 'Ville.class.php';

class VilleManager extends Model
{
    private $ville;

    public function ajoutVille($ville)
    {
        $this->ville = $ville;
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

        return new Ville(
            $ville['id_ville'],
            $ville['nom_ville'],
            $ville['code_postal'],
            $ville['id_pays_ville']
        );
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
        foreach ($villes as $ville) {
            $v = new Ville(
                $ville['id_ville'],
                $ville['nom_ville'],
                $ville['code-postal'],
                $ville['id_pays_ville']
            );
            $this->ajoutVille($v);
        }
        return $villes;
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
        $id_ville = $stmt->lastInsertId('ville');
        $stmt->closeCursor();
        $ville = $this->getVilleById($id_ville);
        return new Ville(
            $ville['id_ville'],
            $ville['nom_ville'],
            $ville['code-postal'],
            $ville['id_pays_ville']
        );
    }


    public function getVilleById($id)
    {
        $req = "SELECT * FROM ville WHERE id_ville = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $ville = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return new Ville(
            $ville['id_ville'],
            $ville['nom_ville'],
            $ville['code-postal'],
            $ville['id_pays_ville']
        );
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
