<?php

/**
 *  Configuration des en-têtes pour gérer le partage de ressources entre origines multiples
 *  (Cross-origin resource sharing => CORS)
 */

// Autorisation de l'accès au serveur par une origine précise
header("Access-Control-Allow-Origin: " . FRONT_END_SERVER);

//  Autorisation des Headers HTTP nécessaires pour les requêtes
header(
  "Access-Control-Allow-Headers: Origin, X-Requested-With, Content, Accept, Content-Type, Authorization"
);

//  Autorisation des types de méthodes de requête
$methodArray = ["GET", "POST", "PUT", "DELETE", "OPTIONS"];
$methodString = "";
$methodAllowed = false;
if (isset($_SERVER["REQUEST_METHOD"])) {
  foreach ($methodArray as $key => $method) {
    $_SERVER["REQUEST_METHOD"] === $method && ($methodAllowed = true);
    $key !== 0 && ($methodString .= ", ");
    $methodString .= $method;
  }
}
$methodAllowed === false && header("HTTP/1.1 405 Method not allowed");
header("Access-Control-Allow-Methods: " . $methodString);

//  Autorisation du type de contenu à l'intérieur des requêtes
header("Content-Type: application/x-www-form-urlencoded");
