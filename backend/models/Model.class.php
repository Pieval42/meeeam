<?php

/**
 * Modèle de base contenant des méthodes nécessaires aux autres modèles.
 * 
 * @author Pierrick Valentin
 * 
 * @since  1.0.0
 */
abstract class Model
{
  private static $pdo;

  /**
   * Paramètre la connexion à la BDD.
   *
   * @return void
   */
  private static function setBdd()
  {
    $dbHost = getenv("DB_HOST"); // Localisation du serveur de la BDD
    $dbName = getenv("DB_NAME"); // Nom de la BDD
    $dbUsername = getenv("DB_USER"); // Nom d'utilisateur pour la connexion à la BDD
    $dbPassword = getenv("DB_PASSWORD"); // Mot de passe de connexion à la BDD
    $dbCharset = "utf8"; // Type d'encodage de caractère de la BDD
    self::$pdo = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName . ";charset=" . $dbCharset, $dbUsername, $dbPassword);
    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }

  /**
   * Raccourci de connexion à la BDD.
   *
   * @return Object Représentation de la connexion à la BDD.
   */
  protected function getBdd()
  {
    if (self::$pdo === null) {
      self::setBdd();
    }
    return self::$pdo;
  }
}
