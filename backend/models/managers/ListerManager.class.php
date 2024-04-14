<?php

require_once __DIR__ . "/../" . 'Model.class.php';
require_once __DIR__ . "/../" . 'Lister.class.php';

class ListerManager extends Model
{
    private $lister;

    private function creerObjetLister($correspondance)
    {
        $this->lister = new Lister(
            $correspondance["id_utilisateur_site_web"],
            $correspondance["adresse_site_web_liste"]
        );
    }

    public function getCorrespondance($id_utilisateur_site_web, $adresse_site_web_liste)
    {
        $req = "
            SELECT * FROM lister
            WHERE id_utilisateur_site_web = :id_utilisateur_site_web
                AND adresse_site_web_liste = :adresse_site_web_liste
        ";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur_site_web', $id_utilisateur_site_web, PDO::PARAM_INT);
        $stmt->bindValue(':adresse_site_web_liste', $adresse_site_web_liste, PDO::PARAM_STR);
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

    public function getAllSitesByUtilisateur($id_utilisateur_site_web, $limit = null)
    {
        $req = "
            SELECT * FROM lister
            WHERE id_utilisateur_site_web = :id_utilisateur_site_web
            ORDER BY adresse_site_web_liste ASC
        ";
        if ($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur_site_web', $id_utilisateur_site_web, PDO::PARAM_INT);
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $liste = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $listeObjets = [];

        if ($liste) {
            foreach ($liste as $row) {
                $this->creerObjetLister(
                    $row["id_utilisateur_site_web"],
                    $row["adresse_site_web_liste"]
                );
                $listeObjets[] = $this->lister;
            }
        }
        return $listeObjets;
    }

    public function creerCorrespondance($id_utilisateur_site_web, $adresse_site_web_liste)
    {
        $req = "
            INSERT INTO lister
            (id_utilisateur_site_web, adresse_site_web_liste)
            VALUES (:id_utilisateur_site_web, :adresse_site_web_liste)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur_site_web', $id_utilisateur_site_web, PDO::PARAM_INT);
        $stmt->bindValue(':adresse_site_web_liste', $adresse_site_web_liste, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        $correspondance = $this->getCorrespondance($id_utilisateur_site_web, $adresse_site_web_liste);
        if ($correspondance) {
            return $correspondance;
        } else {
            return null;
        }
    }

    public function deleteCorrespondance($id_utilisateur_site_web, $adresse_site_web_liste)
    {
        $req = "DELETE FROM lister WHERE id_utilisateur_site_web = :id_utilisateur_site_web AND adresse_site_web_liste = :adresse_site_web_liste";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur_site_web', $id_utilisateur_site_web, PDO::PARAM_INT);
        $stmt->bindValue(':adresse_site_web_liste', $adresse_site_web_liste, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
