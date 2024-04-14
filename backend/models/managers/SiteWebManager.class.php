<?php

require_once __DIR__ . "/../" . 'Model.class.php';
require_once __DIR__ . "/../" . 'SiteWeb.class.php';

class SiteWebManager extends Model
{
    private $site_web;

    private function creerObjetSiteWeb($site_web)
    {
        $this->site_web = new SiteWeb(
            $site_web['adresse_site_web'],
        );
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

        if ($site_web) {
            $this->creerObjetSiteWeb($site_web);
            return $this->site_web;
        } else {
            return null;
        }
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

        $allSiteWebs = [];

        if ($site_webs) {
            foreach ($site_webs as $site_web) {
                $this->creerObjetSiteWeb($site_web);
                $allSiteWebs[] = $this->site_web;
            }
        }
        return $allSiteWebs;
    }

    public function creerSiteWeb($adresse_site_web)
    {
        $site_web_existant = $this->getSiteWeb($adresse_site_web);
        if ($site_web_existant) {
            return $site_web_existant->getAdresseSiteWeb() === $adresse_site_web && $site_web_existant;
        }
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
        if ($site_web) {
            return $site_web;
        } else {
            return null;
        }
    }

    public function deleteSiteWeb($adresse_site_web)
    {
        $req = "DELETE FROM site_web WHERE adresse_site_web = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':adresse_site_web', $adresse_site_web, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
