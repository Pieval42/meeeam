<?php

/**
 * Représentation de la table SQL `demande_ami`
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
class DemandeAmi {
    private $id_demande_ami;
    private $statut_demande;
    private $id_expediteur_demande;
    private $id_destinataire_demande;

    public function __construct($id_demande_ami, $statut_demande, $id_expediteur_demande, $id_destinataire_demande) {
        $this->id_demande_ami = $id_demande_ami;
        $this->statut_demande = $statut_demande;
        $this->id_expediteur_demande = $id_expediteur_demande;
        $this->id_destinataire_demande = $id_destinataire_demande;
    }

    public function getIdDemandeAmi() {
        return $this->id_demande_ami;
    }

    public function getStatutDemande() {
        return $this->statut_demande;
    }

    public function setStatutDemande($statut_demande) {
        $this->statut_demande = $statut_demande;
    }

    public function getIdExpediteurDemande() {
        return $this->id_expediteur_demande;
    }

    public function setIdExpediteurDemande($id_expediteur_demande) {
        $this->id_expediteur_demande = $id_expediteur_demande;
    }

    public function getIdDestinataireDemande() {
        return $this->id_destinataire_demande;
    }

    public function setIdDestinataireDemande($id_destinataire_demande) {
        $this->id_destinataire_demande = $id_destinataire_demande;
    }
}
?>
