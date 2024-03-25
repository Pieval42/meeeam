<?php

class SiteWeb {
    private $adresse_site_web;

    public function __construct($adresse_site_web) {
        $this->adresse_site_web = $adresse_site_web;
    }

    public function getAdresseSiteWeb() {
        return $this->adresse_site_web;
    }

    public function setAdresseSiteWeb($adresse_site_web) {
        $this->adresse_site_web = $adresse_site_web;
    }
}
