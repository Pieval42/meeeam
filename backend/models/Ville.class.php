<?php

/**
 * Représentation de la table SQL `ville`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Ville
{
  private $id_ville;
  private $nom_ville;
  private $code_postal;
  private $id_pays_ville;

  public function __construct($id_ville, $nom_ville, $code_postal, $id_pays_ville)
  {
    $this->id_ville = $id_ville;
    $this->nom_ville = $nom_ville;
    $this->code_postal = $code_postal;
    $this->id_pays_ville = $id_pays_ville;
  }

  public function getIdVille()
  {
    return $this->id_ville;
  }

  public function getNomVille()
  {
    return $this->nom_ville;
  }

  public function setNomVille($nom_ville)
  {
    $this->nom_ville = $nom_ville;
  }

  public function getCodePostal()
  {
    return $this->code_postal;
  }

  public function setCodePostal($code_postal)
  {
    $this->code_postal = $code_postal;
  }

  public function getIdPaysVille()
  {
    return $this->id_pays_ville;
  }

  public function setIdPaysVille($id_pays_ville)
  {
    $this->id_pays_ville = $id_pays_ville;
  }
}
?>
