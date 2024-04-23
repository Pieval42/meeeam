<?php

/**
 * Représentation de la table SQL `genre`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Genre {
    private $id_genre;
    private $libelle_genre;

    public function __construct($id_genre, $libelle_genre) {
        $this->id_genre = $id_genre;
        $this->libelle_genre = $libelle_genre;
    }

    public function getIdGenre() {
        return $this->id_genre;
    }

    public function setIdGenre($id_genre) {
        $this->id_genre = $id_genre;
    }

    public function getLibelleGenre() {
        return $this->libelle_genre;
    }

    public function setLibelleGenre($libelle_genre) {
        $this->libelle_genre = $libelle_genre;
    }
}
?>
