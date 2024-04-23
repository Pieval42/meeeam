<?php

/**
 * Représentation de la table SQL `etre_ami`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class EtreAmi {
    private $id_expediteur_ami;
    private $id_destinataire_ami;
    private $date_debut_amitie;

    public function __construct($id_expediteur_ami, $id_destinataire_ami, $date_debut_amitie) {
        $this->id_expediteur_ami = $id_expediteur_ami;
        $this->id_destinataire_ami = $id_destinataire_ami;
        $this->date_debut_amitie = $date_debut_amitie;
    }

    public function getIdExpediteurAmi() {
        return $this->id_expediteur_ami;
    }

    public function getIdDestinataireAmi() {
        return $this->id_destinataire_ami;
    }

    public function getDateDebutAmitie() {
        return $this->date_debut_amitie;
    }
}
?>
