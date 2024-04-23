<?php

/**
 * Représentation de la table SQL `site_web`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class SiteWeb
{
  private $adresse_site_web;

  public function __construct($adresse_site_web)
  {
    $this->adresse_site_web = $adresse_site_web;
  }

  public function getAdresseSiteWeb()
  {
    return $this->adresse_site_web;
  }

  public function setAdresseSiteWeb($adresse_site_web)
  {
    $this->adresse_site_web = $adresse_site_web;
  }
}
