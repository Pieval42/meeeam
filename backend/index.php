<?php

/**
 *  API du réseau social Meeeam
 *
 *  Ce projet est réalisé dans le cadre de mes études en BTS SIO SLAM
 * 
 * @author  Pierrick Valentin
 *
 * @version 1.0.0
 * 
 */

/**
 *  index.php
 * 
 *  Point d'entrée de l'API
 * 
 *  Analyse de l'URL appelée et routage vers les méthodes souhaitées
 * 
 */
require __DIR__ . "/config/config.php";
require_once __DIR__ . "/config/config_requetes.php";
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . "/controllers/BaseController.controller.php";

try {
  //  Décomposition de l'URL en plusieurs segments
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $uri = explode('/', $uri);

  /**
   * Fonction d'appel de la méthode demandée par l'URL
   *
   * @param  string   $controllerName Nom du contrôleur correspondant
   * @param  string   $methodName     Nom de la méthode correspondant
   * 
   * @return void
   */
  function setEndpoint($controllerName, $methodName)
  {
    require PROJECT_ROOT_PATH . "/controllers/" . $controllerName . ".controller.php";
    $className = $controllerName . "Controller";
    $controller = new $className();

    $controller->{$methodName}();
  }

  switch ($uri[4]) {
    case "authentification":
      $controllerName = "Authentification";
      $methodName = $uri[4];
      break;
      
    case 'utilisateur':
      $controllerName = "Utilisateur";
      if (!isset($uri[5])) {
        header("HTTP/1.1 404 Not Found");
        throw new Exception("URL Invalide");
      } else {
        $methodName = $uri[5];
      }
      break;

    case 'connexion':
      $controllerName = "Connexion";
      $methodName = $uri[4];
      break;

    case 'pays':
      $controllerName = "Pays";
      $methodName = $uri[4];
      break;

    case 'inscription':
      $controllerName = "Inscription";
      $methodName = $uri[4];
      break;

    case 'messages':
      $controllerName = "MessagePrive";
      if (!isset($uri[5])) {
        header("HTTP/1.1 404 Not Found");
        throw new Exception("URL Invalide");
      } else {
        $methodName = $uri[5] . $controllerName;
      }
      break;

    case 'profil':
      $controllerName = "Profil";
      if (!isset($uri[5])) {
        header("HTTP/1.1 404 Not Found");
        throw new Exception("URL Invalide");
      } else {
        $methodName = $uri[5];
      }
      break;

    default:
      header("HTTP/1.1 404 Not Found");
      throw new Exception("URL Invalide");
      break;
  }

  setEndpoint($controllerName, $methodName);
} catch (Exception $e) {
  $baseController = new BaseController();
  $baseController->createResponse("error", $e->getMessage());
}
