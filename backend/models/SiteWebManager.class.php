<?php

require_once 'Model.class.php';
require_once 'SiteWeb.class.php';

class SiteWebManager extends Model
{
    private $site_web;

    public function ajoutSiteWeb($site_web)
    {
        $this->site_web = $site_web;
    }

    public function getSiteWeb($adresse_site_web)
    {
        $req = "
            SELECT * FROM site_web
            WHERE adresse_site_web = :adresse_site_web
        ";

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':adresse_site_web', $adresse_site_web, PDO::PARAM_STR);
        $stmt->execute();
        $site_web = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return new SiteWeb(
            $site_web['adresse_site_web'],
        );
    }

    public function getAllSiteWebs($limit = null)
    {
        $req = "
            SELECT * FROM site_web
            ORDER BY adresse_site_web ASC
        ";
        if ($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $site_webs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($site_webs as $site_web) {
            $v = new SiteWeb(
                $site_web['adresse_site_web'],
            );
            $this->ajoutSiteWeb($v);
        }
        return $site_webs;
    }

    public function creerSiteWeb($adresse_site_web)
    {
        $req = "
            INSERT INTO site_web
            (adresse_site_web)
            VALUES (:adresse_site_web)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':adresse_site_web', $adresse_site_web, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        $site_web = $this->getSiteWeb($adresse_site_web);
        return new SiteWeb(
            $site_web['adresse_site_web'],
        );
    }

    public function deleteSiteWeb($adresse_site_web)
    {
        $req = "DELETE FROM site_web WHERE adresse_site_web = :adresse_site_web";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':adresse_site_web', $adresse_site_web, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
