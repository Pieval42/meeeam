<?php

abstract class Model
{
    private static $pdo;

    private static function setBdd()
    {
        self::$pdo = new PDO(DB_INFOS, DB_USERNAME, DB_PASSWORD);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    protected function getBdd()
    {
        if (self::$pdo === null) {
            self::setBdd();
        }
        return self::$pdo;
    }

    protected function convertirDate($date)
    {
        $date_est_valide = false;

        // Séparation du jour, mois et année
        $elements_date = explode('/', $date);

        // Vérification si la date est au format correct (jj/mm/aaaa)
        if (count($elements_date) != 3 || !checkdate($elements_date[1], $elements_date[0], $elements_date[2])) {
            $date_est_valide = false; // La date est invalide
        } else {
            $date_est_valide = true; // La date est valide
        }

        // Création de la date au format MySQL (aaaa-mm-jj) si la date est valide
        if($date_est_valide) {
            $date_mysql = $elements_date[2] . '-' . $elements_date[1] . '-' . $elements_date[0];
        }

        return $date_mysql;
    }
}
