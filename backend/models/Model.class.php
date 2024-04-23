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
    self::$pdo = new PDO(DB_INFOS, DB_USERNAME, DB_PASSWORD);
    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }
  
  /**
   * Raccourci de connexion à la BDD.
   *
   * @return void
   */
  protected function getBdd()
  {
    if (self::$pdo === null) {
      self::setBdd();
    }
    return self::$pdo;
  }
}
