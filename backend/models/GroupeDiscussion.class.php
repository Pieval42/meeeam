<?php

class GroupeDiscussion {
    private $id_groupe_discussion;
    private $nom_groupe_discussion;
    private $id_createur_groupe_discussion;

    public function __construct($id_groupe_discussion, $nom_groupe_discussion, $id_createur_groupe_discussion) {
        $this->id_groupe_discussion = $id_groupe_discussion;
        $this->nom_groupe_discussion = $nom_groupe_discussion;
        $this->id_createur_groupe_discussion = $id_createur_groupe_discussion;
    }

    public function getIdGroupeDiscussion() {
        return $this->id_groupe_discussion;
    }

    public function setIdGroupeDiscussion($id_groupe_discussion) {
        $this->id_groupe_discussion = $id_groupe_discussion;
    }

    public function getNomGroupeDiscussion() {
        return $this->nom_groupe_discussion;
    }

    public function setNomGroupeDiscussion($nom_groupe_discussion) {
        $this->nom_groupe_discussion = $nom_groupe_discussion;
    }

    public function getIdCreateurGroupeDiscussion() {
        return $this->id_createur_groupe_discussion;
    }

    public function setIdCreateurGroupeDiscussion($id_createur_groupe_discussion) {
        $this->id_createur_groupe_discussion = $id_createur_groupe_discussion;
    }
}
