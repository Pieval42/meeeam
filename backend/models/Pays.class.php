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
  private $nom_pays;

  public function __construct($id_pays, $nom_pays)
  {
    $this->id_pays = $id_pays;
    $this->nom_pays = $nom_pays;
  }

  public function getIdPays()
  {
    return $this->id_pays;
  }

  public function setIdPays($id_pays)
  {
    $this->id_pays = $id_pays;
  }

  public function getNomPays()
  {
    return $this->nom_pays;
  }

  public function setNomPays($nom_pays)
  {
    $this->nom_pays = $nom_pays;
  }
}
?>
