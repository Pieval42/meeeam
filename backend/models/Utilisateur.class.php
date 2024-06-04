<?php

/**
 * Représentation de la table SQL `utilisateur`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Utilisateur
{
  private $id_utilisateur;
  private $pseudo_utilisateur;
  private $nom_utilisateur;
  private $prenom_utilisateur;
  private $date_naissance;
  private $email_utilisateur;
  private $mot_de_passe;
  private $date_inscription;
  private $id_genre_utilisateur;
  private $id_ville_utilisateur;
  private $accepte_cgu;
  private $arrayDetailsUtilisateur;

  public function __construct($id_utilisateur, $pseudo_utilisateur, $nom_utilisateur, $prenom_utilisateur, $date_naissance, $email_utilisateur, $mot_de_passe, $date_inscription, $id_genre_utilisateur, $id_ville_utilisateur, $accepte_cgu)
  {
    $this->id_utilisateur = $id_utilisateur;
    $this->pseudo_utilisateur = $pseudo_utilisateur;
    $this->nom_utilisateur = $nom_utilisateur;
    $this->prenom_utilisateur = $prenom_utilisateur;
    $this->date_naissance = $date_naissance;
    $this->email_utilisateur = $email_utilisateur;
    $this->mot_de_passe = $mot_de_passe;
    $this->date_inscription = $date_inscription;
    $this->id_genre_utilisateur = $id_genre_utilisateur;
    $this->id_ville_utilisateur = $id_ville_utilisateur;
    $this->accepte_cgu = $accepte_cgu;
  }

  public function getIdUtilisateur()
  {
    return $this->id_utilisateur;
  }

  public function getPseudoUtilisateur()
  {
    return $this->pseudo_utilisateur;
  }

  public function setPseudoUtilisateur($pseudo_utilisateur)
  {
    $this->pseudo_utilisateur = $pseudo_utilisateur;
  }

  public function getNomUtilisateur()
  {
    return $this->nom_utilisateur;
  }

  public function setNomUtilisateur($nom_utilisateur)
  {
    $this->nom_utilisateur = $nom_utilisateur;
  }

  public function getPrenomUtilisateur()
  {
    return $this->prenom_utilisateur;
  }

  public function setPrenomUtilisateur($prenom_utilisateur)
  {
    $this->prenom_utilisateur = $prenom_utilisateur;
  }

  public function getDateNaissance()
  {
    return $this->date_naissance;
  }

  public function setDateNaissance($date_naissance)
  {
    $this->date_naissance = $date_naissance;
  }

  public function getEmailUtilisateur()
  {
    return $this->email_utilisateur;
  }

  public function setEmailUtilisateur($email_utilisateur)
  {
    $this->email_utilisateur = $email_utilisateur;
  }

  public function getMotDePasse()
  {
    return $this->mot_de_passe;
  }

  public function setMotDePasse($mot_de_passe)
  {
    $this->mot_de_passe = $mot_de_passe;
  }

  public function getDateInscription()
  {
    return $this->date_inscription;
  }

  public function setDateInscription($date_inscription)
  {
    $this->date_inscription = $date_inscription;
  }

  public function getIdGenreUtilisateur()
  {
    return $this->id_genre_utilisateur;
  }

  public function setIdGenreUtilisateur($id_genre_utilisateur)
  {
    $this->id_genre_utilisateur = $id_genre_utilisateur;
  }

  public function getIdVilleUtilisateur()
  {
    return $this->id_ville_utilisateur;
  }

  public function setIdVilleUtilisateur($id_ville_utilisateur)
  {
    $this->id_ville_utilisateur = $id_ville_utilisateur;
  }

  public function toArray($utilisateur) {
    $this->arrayDetailsUtilisateur["id_utilisateur"] = $utilisateur->getIdUtilisateur();
    $this->arrayDetailsUtilisateur["pseudo_utilisateur"] = $utilisateur->getPseudoUtilisateur();
    $this->arrayDetailsUtilisateur["nom_utilisateur"] = $utilisateur->getNomUtilisateur();
    $this->arrayDetailsUtilisateur["prenom_utilisateur"] = $utilisateur->getPrenomUtilisateur();
    $this->arrayDetailsUtilisateur["date_naissance"] = $utilisateur->getDateNaissance();

    return $this->arrayDetailsUtilisateur;
  }
}
?>
