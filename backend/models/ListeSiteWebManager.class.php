<?php

require_once 'Model.class.php';
require_once 'ListeSiteWeb.class.php';

class ListeSiteWebManager extends Model
{
    private $liste_site_web;

    public function ajoutListeSiteWeb($liste_site_web)
    {
        $this->liste_site_web = $liste_site_web;
    }

    public function getListeSiteWeb($id_utilisateur_site_web, $adresse_site_web_liste)
    {
        $req = "
            SELECT * FROM liste_site_web
            WHERE id_utilisateur_site_web = :id_utilisateur_site_web AND adresse_site_web_liste = :adresse_site_web_liste
        ";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur_site_web', $id_utilisateur_site_web, PDO::PARAM_STR);
        $stmt->bindValue(':adresse_site_web_liste', $adresse_site_web_liste, PDO::PARAM_STR);
        $stmt->execute();
        $liste_site_web = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return new ListeSiteWeb(
            $liste_site_web['id_utilisateur_site_web'],
            $liste_site_web['adresse_site_web_liste'],
        );
    }

    public function getAllListeSiteWebs($limit = null)
    {
        $req = "
            SELECT * FROM liste_site_web
            ORDER BY adresse_site_web_liste ASC
        ";
        if ($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $liste_site_webs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($liste_site_webs as $liste_site_web) {
            $l = new ListeSiteWeb(
                $liste_site_web['id_utilisateur_site_web'],
                $liste_site_web['adresse_site_web_liste'],
            );
            $this->ajoutListeSiteWeb($l);
        }
        return $liste_site_webs;
    }

    public function creerListeSiteWeb($id_utilisateur_site_web, $adresse_site_web_liste)
    {
        $req = "
            INSERT INTO liste_site_web
            (id_utilisateur_site_web, adresse_site_web_liste)
            VALUES (:id_utilisateur_site_web, :adresse_site_web_liste)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur_site_web', $id_utilisateur_site_web, PDO::PARAM_STR);
        $stmt->bindValue(':adresse_site_web_liste', $adresse_site_web_liste, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        $liste_site_web = $this->getListeSiteWeb($id_utilisateur_site_web, $adresse_site_web_liste);
        return new ListeSiteWeb(
            $liste_site_web['id_utilisateur_site_web'],
            $liste_site_web['adresse_site_web_liste'],
        );
    }

    public function deleteListeSiteWeb($id_utilisateur_site_web, $adresse_site_web_liste)
    {
        $req = "DELETE FROM liste_site_web WHERE id_utilisateur_site_web = :id_utilisateur_site_web AND adresse_site_web_liste = :adresse_site_web_liste";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur_site_web', $id_utilisateur_site_web, PDO::PARAM_STR);
        $stmt->bindValue(':adresse_site_web_liste', $adresse_site_web_liste, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
