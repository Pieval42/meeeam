<?php

class PagePublique {
    private $id_page_publique;
    private $id_createur_page_publique;

    public function __construct($id_page_publique, $id_createur_page_publique) {
        $this->id_page_publique = $id_page_publique;
        $this->id_createur_page_publique = $id_createur_page_publique;
    }

    public function getIdPagePublique() {
        return $this->id_page_publique;
    }

    public function setIdPagePublique($id_page_publique) {
        $this->id_page_publique = $id_page_publique;
    }

    public function getIdCreateurPagePublique() {
        return $this->id_createur_page_publique;
    }

    public function setIdCreateurPagePublique($id_createur_page_publique) {
        $this->id_createur_page_publique = $id_createur_page_publique;
    }
}
