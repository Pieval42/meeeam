<?php

/**
 * Représentation de la table SQL `bloquer`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class Bloquer {
    private $id_utilisateur_bloquant;
    private $id_utilisateur_bloque;

    public function __construct($id_utilisateur_bloquant, $id_utilisateur_bloque) {
        $this->id_utilisateur_bloquant = $id_utilisateur_bloquant;
        $this->id_utilisateur_bloque = $id_utilisateur_bloque;
    }

    public function getIdUtilisateurBloquant() {
        return $this->id_utilisateur_bloquant;
    }

    public function getIdUtilisateurBloque() {
        return $this->id_utilisateur_bloque;
    }
}

?>
