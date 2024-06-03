<?php

/**
 * Représentation de la table SQL `pays`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Pays
{
  private $id_pays;
  private $code_pays;
  private $nom_fr;
  private $nom_en;

  public function __construct($id_pays, $code_pays, $nom_fr, $nom_en)
  {
    $this->id_pays = $id_pays;
    $this->code_pays = $code_pays;
    $this->nom_fr = $nom_fr;
    $this->nom_en = $nom_en;
  }

  public function getIdPays()
  {
    return $this->id_pays;
  }

  public function setIdPays($id_pays)
  {
    $this->id_pays = $id_pays;
  }

  public function getCodePays()
  {
    return $this->code_pays;
  }

  public function setCodePays($code_pays)
  {
    $this->code_pays = $code_pays;
  }

  public function getNomFr()
  {
    return $this->nom_fr;
  }

  public function getNomEn()
  {
    return $this->nom_en;
  }
}
