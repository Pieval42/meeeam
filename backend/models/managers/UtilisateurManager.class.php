<?php

require_once __DIR__ . "/../Model.class.php";
require_once __DIR__ . "/../Utilisateur.class.php";

/**
 * Gestion des requêtes SQL en lien avec la table `utilisateur`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class UtilisateurManager extends Model
{
  /**
   * Objet représentant un utilisateur
   *
   * @var object
   */
  private $utilisateur;

  /**
   * Crée un attribut utilisateur
   *
   * @param  object $utilisateur
   * 
   * @return void
   */
  public function ajoutUtilisateur($utilisateur)
  {
    $this->utilisateur = $utilisateur;
  }

  /**
   * Récupère la liste de tous les utilisateurs présent dans la BDD
   *
   * @param  int $limit option pour limiter le nombre de résultats
   * 
   * @return array Tableau contenant tous les utilisateurs.
   */
  public function getAllUtilisateurs($limit = null)
  {
    $req =
      "SELECT * FROM utilisateur
        ORDER BY pseudo_utilisateur ASC";
    if ($limit) {
      $req .= " LIMIT :limit";
    }
    $stmt = $this->getBdd()->prepare($req);
    if ($limit) {
      $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($utilisateurs as $utilisateur) {
      $u = new Utilisateur(
        $utilisateur["id_utilisateur"],
        $utilisateur["pseudo_utilisateur"],
        $utilisateur["nom_utilisateur"],
        $utilisateur["prenom_utilisateur"],
        $utilisateur["date_naissance"],
        $utilisateur["email_utilisateur"],
        $utilisateur["mot_de_passe"],
        $utilisateur["date_inscription"],
        $utilisateur["id_genre_utilisateur"],
        $utilisateur["id_ville_utilisateur"]
      );
      $this->ajoutUtilisateur($u);
    }
    return $utilisateurs;
  }
  
  /**
   * Recherche un utilisateur à partir d'une chaîne de caractères.
   *
   * @param  string $search
   * 
   * @return array Tableau contenant les utilisateurs correspondants.
   */
  public function searchUtilisateurs($search)
  {
    $search .= "%";
    $req =
      "SELECT * FROM utilisateur
        WHERE pseudo_utilisateur LIKE :search
        OR prenom_utilisateur LIKE :search
        OR nom_utilisateur LIKE :search
        OR CONCAT(prenom_utilisateur, ' ', nom_utilisateur) LIKE :search
        OR CONCAT(nom_utilisateur, ' ', prenom_utilisateur) LIKE :search
        ORDER BY pseudo_utilisateur ASC";
    $stmt = $this->getBdd()->prepare($req);

    $stmt->bindValue(":search", $search, PDO::PARAM_STR);
    $stmt->execute();
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($utilisateurs as $utilisateur) {
      $u = new Utilisateur(
        $utilisateur["id_utilisateur"],
        $utilisateur["pseudo_utilisateur"],
        $utilisateur["nom_utilisateur"],
        $utilisateur["prenom_utilisateur"],
        $utilisateur["date_naissance"],
        $utilisateur["email_utilisateur"],
        $utilisateur["mot_de_passe"],
        $utilisateur["date_inscription"],
        $utilisateur["id_genre_utilisateur"],
        $utilisateur["id_ville_utilisateur"]
      );
      $this->ajoutUtilisateur($u);
    }
    return $utilisateurs;
  }
  
  /**
   * Récupère le dernier utilisateur créé.
   *
   * @return object Objet représentant le dernier utilisateur crée.
   */
  public function getLastUtilisateur()
  {
    $req =
      "SELECT * FROM utilisateur
        ORDER BY id_utilisateur DESC
        LIMIT 1";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return new Utilisateur(
      $utilisateur["id_utilisateur"],
      $utilisateur["pseudo_utilisateur"],
      $utilisateur["nom_utilisateur"],
      $utilisateur["prenom_utilisateur"],
      $utilisateur["date_naissance"],
      $utilisateur["email_utilisateur"],
      $utilisateur["mot_de_passe"],
      $utilisateur["date_inscription"],
      $utilisateur["id_genre_utilisateur"],
      $utilisateur["id_ville_utilisateur"]
    );
  }
  
  /**
   * Crée un utilisateur.
   * 
   * @param  string  $pseudo         Ne doit pas déjà exister dans la BDD.
   * @param  string  $nom
   * @param  string  $prenom
   * @param  string  $date_naissance
   * @param  string  $email          Ne doit pas déjà exister dans la BDD.
   * @param  string  $mot_de_passe
   * @param  string  $id_genre
   * @param  int     $id_ville
   * 
   * @return object  Objet représentant l'utilisateur créé.
   */
  public function creerUtilisateur(
    $pseudo,
    $nom,
    $prenom,
    $date_naissance,
    $email,
    $mot_de_passe,
    $id_genre = "I",
    $id_ville = null
  ) {
    //  Vérifie si le pseudo est déjà utilisé.
    $pseudoAlreadyExists = $this->getUtilisateurByPseudo($pseudo);
    if ($pseudoAlreadyExists) {
      throw new Exception("Pseudo déjà utilisé. Veuillez en choisir un autre.");
    }

    //  Vérifie si l'adresse email est déjà utilisée.
    $emailAlreadyExists = $this->getUtilisateurByEmail($email);
    if ($emailAlreadyExists) {
      throw new Exception("Adresse e-mail déjà utilisée. Veuillez en choisir une autre.");
    }
    $id_genre === "" && $id_genre = "I";
    $req =
      "INSERT INTO utilisateur
        (pseudo_utilisateur, nom_utilisateur, prenom_utilisateur, date_naissance, email_utilisateur, mot_de_passe, id_genre_utilisateur, id_ville_utilisateur)
        VALUES (:pseudo, :nom, :prenom, :date_naissance, :email, :mot_de_passe, :id_genre, :id_ville)";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
    $stmt->bindValue(":date_naissance", $date_naissance, PDO::PARAM_STR);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
    $stmt->bindValue(":id_genre", $id_genre, PDO::PARAM_STR);
    $stmt->bindValue(":id_ville", $id_ville, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
    $utilisateur = $this->getLastUtilisateur();
    $id_utilisateur = $utilisateur->getIdUtilisateur();
    $date_inscription = $utilisateur->getDateNaissance();
    return new Utilisateur(
      $id_utilisateur,
      $pseudo,
      $nom,
      $prenom,
      $date_naissance,
      $email,
      $mot_de_passe,
      $date_inscription,
      $id_genre,
      $id_ville
    );
  }
  
  /**
   * Récupère un utilisateur grâce à son identifiant.
   *
   * @param  int  $id
   * 
   * @return object  Objet représentant l'utilisateur trouvé.
   */
  public function getUtilisateurById($id)
  {
    $req = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return new Utilisateur(
      $utilisateur["id_utilisateur"],
      $utilisateur["pseudo_utilisateur"],
      $utilisateur["nom_utilisateur"],
      $utilisateur["prenom_utilisateur"],
      $utilisateur["date_naissance"],
      $utilisateur["email_utilisateur"],
      $utilisateur["mot_de_passe"],
      $utilisateur["date_inscription"],
      $utilisateur["id_genre_utilisateur"],
      $utilisateur["id_ville_utilisateur"]
    );
  }
  
  /**
   * Récupère un utilisateur grâce à son adresse e-mail.
   *
   * @param  string $email
   * 
   * @return object|false Objet représentant l'utilisateur trouvé, false s'il n'existe pas.
   */
  public function getUtilisateurByEmail($email)
  {
    $req = "SELECT * FROM utilisateur WHERE email_utilisateur = :email";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if ($utilisateur === false) {
      return $utilisateur;
    } else {
      return new Utilisateur(
        $utilisateur["id_utilisateur"],
        $utilisateur["pseudo_utilisateur"],
        $utilisateur["nom_utilisateur"],
        $utilisateur["prenom_utilisateur"],
        $utilisateur["date_naissance"],
        $utilisateur["email_utilisateur"],
        $utilisateur["mot_de_passe"],
        $utilisateur["date_inscription"],
        $utilisateur["id_genre_utilisateur"],
        $utilisateur["id_ville_utilisateur"]
      );
    }
  }

  /**
   * Récupère un utilisateur grâce à son pseudo.
   *
   * @param  string $pseudo
   * 
   * @return object|false Objet représentant l'utilisateur trouvé, false s'il n'existe pas.
   */
  public function getUtilisateurByPseudo($pseudo)
  {
    $req =
      "SELECT * FROM utilisateur WHERE pseudo_utilisateur = :pseudo LIMIT 1";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":pseudo", $pseudo);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if ($utilisateur === false) {
      return $utilisateur;
    } else {
      return new Utilisateur(
        $utilisateur["id_utilisateur"],
        $utilisateur["pseudo_utilisateur"],
        $utilisateur["nom_utilisateur"],
        $utilisateur["prenom_utilisateur"],
        $utilisateur["date_naissance"],
        $utilisateur["email_utilisateur"],
        $utilisateur["mot_de_passe"],
        $utilisateur["date_inscription"],
        $utilisateur["id_genre_utilisateur"],
        $utilisateur["id_ville_utilisateur"]
      );
    }
  }
  
  /**
   * Modifie les données d'un utilisateur.
   *
   * @param  int     $id
   * @param  string  $pseudo         Ne doit pas être déjà pris par un autre utilisateur.
   * @param  string  $nom
   * @param  string  $prenom
   * @param  string  $date_naissance
   * @param  string  $email          Ne doit pas être déjà pris par un autre utilisateur.
   * @param  string  $mot_de_passe
   * @param  int     $id_genre
   * @param  int     $id_ville
   * 
   * @return void
   */
  public function updateUtilisateur(
    $id,
    $pseudo,
    $nom,
    $prenom,
    $date_naissance,
    $email,
    $mot_de_passe,
    $id_genre,
    $id_ville
  ) {
    $req =
      "UPDATE utilisateur
        SET pseudo_utilisateur = :pseudo, nom_utilisateur = :nom, prenom_utilisateur = :prenom, date_naissance = :date_naissance,
          email_utilisateur = :email, mot_de_passe = :mot_de_passe, id_genre_utilisateur = :id_genre, id_ville_utilisateur = :id_ville
        WHERE id_utilisateur = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
    $stmt->bindValue(":date_naissance", $date_naissance, PDO::PARAM_STR);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
    $stmt->bindValue(":id_genre", $id_genre, PDO::PARAM_INT);
    $stmt->bindValue(":id_ville", $id_ville, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }
  
  /**
   * Supprime un utilisateur.
   *
   * @param  int  $id
   * 
   * @return void
   */
  public function deleteUtilisateur($id)
  {
    $req = "DELETE FROM utilisateur WHERE id_utilisateur = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
  }
}
?>
