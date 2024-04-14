<?php

require_once __DIR__ . "/../" . 'Model.class.php';
require_once __DIR__ . "/../" . 'PageProfil.class.php';

class PageProfilManager extends Model {

    public function getPageProfilByIdUtilisateur($id_utilisateur)
    {
        $req =  "   SELECT * FROM page_profil
                    WHERE id_utilisateur_page_profil = :id_utilisateur
                ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $res["id_page_profil"];
    }

    public function creerPageProfil($id_utilisateur) {
        $req =  "   INSERT INTO page_profil
                    (id_utilisateur_page_profil)
                    VALUES (:id_utilisateur)
                ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

}

?>