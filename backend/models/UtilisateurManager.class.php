<?php

require_once 'Model.class.php';
require_once 'Utilisateur.class.php';

class UtilisateurManager extends Model {
    private $utilisateur;
    
    public function ajoutUtilisateur($utilisateur){
        $this->utilisateur = $utilisateur;
    }
    
    public function getUtilisateur(){
        return $this->utilisateur;
    }

    public function getAllUtilisateurs($limit) {
        $req = "
            SELECT * FROM utilisateur
            ORDER BY pseudo_utilisateur ASC
        ";
        if($limit) {
            $req .= " LIMIT :limit";
        }
        $stmt = $this->getBdd()->prepare($req);
        if($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($utilisateurs as $utilisateur){
            $u = new Utilisateur(
                $utilisateur['id_utilisateur'],
                $utilisateur['pseudo_utilisateur'],
                $utilisateur['nom_utilisateur'],
                $utilisateur['prenom_utilisateur'],
                $utilisateur['date_naissance'],
                $utilisateur['email_utilisateur'],
                $utilisateur['mot_de_passe'],
                $utilisateur['date_inscription'],
                $utilisateur['id_genre_utilisateur'],
                $utilisateur['id_ville_utilisateur']
            );
            $this->ajoutUtilisateur($u);
        }
        return $utilisateurs;
    }

    public function getLastUtilisateur() {
        $req = "
            SELECT * FROM utilisateur
            ORDER BY id_utilisateur DESC
            LIMIT 1
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
            
        return new Utilisateur(
            $utilisateur['id_utilisateur'],
            $utilisateur['pseudo_utilisateur'],
            $utilisateur['nom_utilisateur'],
            $utilisateur['prenom_utilisateur'],
            $utilisateur['date_naissance'],
            $utilisateur['email_utilisateur'],
            $utilisateur['mot_de_passe'],
            $utilisateur['date_inscription'],
            $utilisateur['id_genre_utilisateur'],
            $utilisateur['id_ville_utilisateur']
        );
        
    }
    
    public function creerUtilisateur($pseudo, $nom, $prenom, $date_naissance, $email, $mot_de_passe, $id_genre=null, $id_ville=null) {
        $req = "
            INSERT INTO utilisateur
            (pseudo_utilisateur, nom_utilisateur, prenom_utilisateur, date_naissance, email_utilisateur, mot_de_passe, id_genre_utilisateur, id_ville_utilisateur)
            VALUES (:pseudo, :nom, :prenom, :date_naissance, :email, :mot_de_passe, :id_genre, :id_ville)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':pseudo', $pseudo,PDO::PARAM_STR);
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindValue(':date_naissance', $date_naissance, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $stmt->bindValue(':id_genre', $id_genre, PDO::PARAM_STR);
        $stmt->bindValue(':id_ville', $id_ville, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        $utilisateur = $this->getLastUtilisateur();
        $id_utilisateur = $utilisateur->getIdUtilisateur();
        $date_inscription = $utilisateur->getDateNaissance();
        return new Utilisateur($id_utilisateur, $pseudo, $nom, $prenom, $date_naissance, $email, $mot_de_passe, $date_inscription, $id_genre, $id_ville);
    }


    public function getUtilisateurById($id) {
        $req = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return new Utilisateur(
            $utilisateur['id_utilisateur'],
            $utilisateur['pseudo_utilisateur'],
            $utilisateur['nom_utilisateur'],
            $utilisateur['prenom_utilisateur'],
            $utilisateur['date_naissance'],
            $utilisateur['email_utilisateur'],
            $utilisateur['mot_de_passe'],
            $utilisateur['date_inscription'],
            $utilisateur['id_genre_utilisateur'],
            $utilisateur['id_ville_utilisateur']
        );
    }

    public function getUtilisateurByEmail($email) {
        $req = "SELECT * FROM utilisateur WHERE email_utilisateur = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return  new Utilisateur(
            $utilisateur['id_utilisateur'],
            $utilisateur['pseudo_utilisateur'],
            $utilisateur['nom_utilisateur'],
            $utilisateur['prenom_utilisateur'],
            $utilisateur['date_naissance'],
            $utilisateur['email_utilisateur'],
            $utilisateur['mot_de_passe'],
            $utilisateur['date_inscription'],
            $utilisateur['id_genre_utilisateur'],
            $utilisateur['id_ville_utilisateur']
        );
    }

    public function updateUtilisateur($id, $pseudo, $nom, $prenom, $date_naissance, $email, $mot_de_passe, $id_genre, $id_ville) {
        $req = "
            UPDATE utilisateur
            SET pseudo_utilisateur = :pseudo, nom_utilisateur = :nom, prenom_utilisateur = :prenom, date_naissance = :date_naissance, email_utilisateur = :email, mot_de_passe = :mot_de_passe, id_genre_utilisateur = :id_genre, id_ville_utilisateur = :id_ville
            WHERE id_utilisateur = :id
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pseudo', $pseudo,PDO::PARAM_STR);
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindValue(':date_naissance', $date_naissance, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $stmt->bindValue(':id_genre', $id_genre, PDO::PARAM_INT);
        $stmt->bindValue(':id_ville', $id_ville, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteUtilisateur($id) {
        $req = "DELETE FROM utilisateur WHERE id_utilisateur = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
}

?>
