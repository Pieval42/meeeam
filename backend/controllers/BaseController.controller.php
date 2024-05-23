<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/config_requetes.php";
require_once __DIR__ . "/../models/managers/RequeteManager.class.php";

use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenEncoded;

/**
 *  Méthodes utiles aux autres contrôleurs
 *
 * @author  Pierrick Valentin
 *
 * @since 1.0.0
 */
class BaseController
{
  private $requeteManager;

  /**
   *  Constructeur de la classe
   *
   * @return void
   */
  public function __construct()
  {
    $this->requeteManager = new RequeteManager();
  }

  /**
   * Créé la réponse au format JSON envoyée côté client
   *
   * @param  string $status   Statut de la réponse (success, error)
   * @param  string $message  Message de la réponse
   * @param  array  $data     Données supplémentaires de la réponse
   * @param  string $token    JWT envoyé lors de la connexion d'un utilisateur
   *
   * @return string Réponse au format json
   */
  public function createResponse(
    $status,
    $message,
    $data = new stdClass,
    $accessToken = null,
    $refreshToken = null
  ) {
    $response = [
      "status" => $status,
      "message" => $message,
      "data" => $data,
      "access_token" => $accessToken,
      "refresh_token" => $refreshToken
    ];
    $jsonResponse = json_encode($response);
    $status === "error" && error_log($jsonResponse);
    return $jsonResponse;
  }

  /**
   * Valide le format AAAA-MM-JJ d'une date
   *
   * @param  string  $date Date à valider
   *
   * @return boolean true si la date est valide, false sinon
   */
  private function validateDate($date)
  {
    $d = DateTime::createFromFormat("Y-m-d", $date);
    return $d && $d->format("Y-m-d") == $date;
  }

  /**
   * Permet de vérifier la validité des entrées utilisateur.
   *
   * Vérifie le type, le format et/ou la longueur et/ou la conformité à une expression régulière
   *
   * Peut échapper les caractères spéciaux si $characteristics['escapeHtmlSpecialChars'] = true
   *
   * Pour les valeurs numériques vérifie que la valeur est comprise
   * entre son minimum et maximum autorisé si ceux-ci sont définis
   *
   * Il est possible de définir un message d'erreur personnalisé dans $characteristics['errorMessage']
   *
   * @param  mixed  $inputContent     Contenu de l'entrée à vérifier (string ou int)
   * @param  string $inputName        Nom de l'entrée à vérifier
   * @param  array  $characteristics  Doit être au format suivant :
   *      $characteristics[
   *          'type' => string 'date' || 'url' || 'email' || 'string' || 'integer',   // requis
   *          'regex' => string $regex,                                               // optionnel
   *          'errorMessage' => string $message,                                      // optionnel
   *          'length' => int $length                                                 // optionnel
   *          'range' => ['min' => int $min, 'max' => int $max],                      // optionnel
   *          'escapeHtmlSpecialChars' => boolean $trueOrFalse                        // optionnel
   *      ]
   *
   * @return mixed  Contenu de l'entrée vérifié
   */
  protected function validateInput(
    $inputContent,
    $inputName,
    $characteristics
  ) {
    try {
      $errorMessage = isset($characteristics["errorMessage"])
        ? $characteristics["errorMessage"]
        : null;
      if (
        (!$inputContent || $inputContent == "") &&
        $characteristics["notNull"]
      ) {
        throw new Exception("Champ " . $inputName . " requis.");
      }
      $inputType = gettype($inputContent);
      is_string($inputContent) && ($inputContent = trim($inputContent));

      switch ($characteristics["type"]) {
        case "date":
          if ($inputContent == "") {
            break;
          }
          $dateValide = is_string($inputContent)
            ? $this->validateDate($inputContent)
            : false;
          !$dateValide &&
            throw new Exception(
              $errorMessage
                ? $errorMessage
                : $inputName . " : Format de date invalide"
            );
          break;

        case "url":
          if ($inputContent == "") {
            break;
          }
          $url = strpos($inputContent, 'http') !== 0 ? "http://$inputContent" : $inputContent;
          $urlValide = is_string($url)
            ? filter_var($url, FILTER_VALIDATE_URL)
            : false;
          !$urlValide &&
            throw new Exception(
              $errorMessage
                ? $errorMessage
                : $inputName . " : Format d'URL invalide"
            );
          break;

        case "email":
          if ($inputContent == "") {
            break;
          }
          $emailValide = is_string($inputContent)
            ? filter_var($inputContent, FILTER_VALIDATE_EMAIL)
            : false;
          !$emailValide &&
            throw new Exception(
              $errorMessage
                ? $errorMessage
                : $inputName . " : Format d'email invalide"
            );
          break;

        case "string":
          if ($inputContent == "") {
            break;
          }
          if (is_string($inputContent)) {
            if (isset($characteristics["regex"])) {
              $inputValide = preg_match(
                $characteristics["regex"],
                $inputContent
              );
              if ($inputValide !== 1) {
                throw new Exception(
                  $errorMessage
                    ? $errorMessage
                    : "Caractères invalides dans le champ " .
                    $inputName
                );
              }
            }
            if (
              isset($characteristics["escapeHtmlSpecialChars"]) &&
              $characteristics["escapeHtmlSpecialChars"]
            ) {
              $inputContent = htmlspecialchars(
                $inputContent,
                ENT_QUOTES | ENT_SUBSTITUTE,
                "UTF-8"
              );
            }
            if (
              isset($characteristics["length"]) &&
              strlen($inputContent) > $characteristics["length"]
            ) {
              throw new Exception(
                $errorMessage
                  ? $errorMessage
                  : "Le champ " .
                  $inputName .
                  " contient trop de caractères."
              );
            }
          } else {
            throw new Exception(
              $errorMessage
                ? $errorMessage
                : "Type de données du champ " .
                $inputName .
                " invalide."
            );
          }
          break;

        case "integer":
          is_string($inputContent) &&
            ($inputContent = (int) $inputContent);

          if (is_int($inputContent)) {
            if (
              isset($characteristics["range"]) &&
              ($inputContent < $characteristics["range"]["min"] ||
                $inputContent >
                $characteristics["range"]["max"])
            ) {
              throw new Exception(
                $errorMessage
                  ? $errorMessage
                  : "Valeur du champ " .
                  $inputName .
                  " en dehors des valeurs autorisées."
              );
            }
          } else {
            throw new Exception(
              $errorMessage
                ? $errorMessage
                : "Type de données du champ " .
                $inputName .
                " invalide."
            );
          }
          break;

        default:
          if ($inputType !== $characteristics["type"]) {
            throw new Exception(
              "Type de données du champ " .
                $inputName .
                " invalide."
            );
          } else {
            throw new Exception(
              "Type de données du champ " .
                $inputName .
                " inconnu."
            );
          }
          break;
      }
      return $inputContent;
    } catch (Exception $e) {
      echo $this->createResponse("error", $e->getMessage());
      header("HTTP/1.1 422 Unprocessable entity");
      exit();
    }
  }

  /**
   * Limite le nombre de requêtes pour une même adresse IP afin d'éviter les attaques par force brute
   *
   * @param  string   $adresse_ip
   *
   * @return boolean  true si l'adresse IP est autorisée, false sinon.
   */
  protected function checkRequestLimit($adresse_ip)
  {
    $this->requeteManager = new RequeteManager();
    $requetes = $this->requeteManager->getNbRequetesByIp($adresse_ip);
    $maxRequestNb = 100;

    if (count($requetes) > $maxRequestNb) {
      return false;
    }

    return true;
  }

  /**
   * checkRequestTime
   *
   * @param  string    $adresse_ip
   *
   * @return boolean  true si l'adresse IP est autorisée, false sinon.
   */
  protected function checkRequestTime($adresse_ip)
  {
    $this->requeteManager = new RequeteManager();
    $requete = $this->requeteManager->getHeureRequeteByIp($adresse_ip);
    if ($requete) {
      $heure_derniere_requete = strtotime($requete["date_heure_req"]);
      $heure_actuelle = strtotime(date("Y-m-d H:i:s"));
      if ($heure_actuelle - $heure_derniere_requete < 1) {
        return false;
      }
    }

    return true;
  }

  /**
   * Vérifie la validité d'un JSON Web Token (JWT)
   *
   * Nécessite la bibliothèque "php-jwt"
   * https://github.com/nowakowskir/php-jwt
   * Copyright 2019 Nowakowski Radosław
   *
   * @param  string $token        Token à vérifier au format JSON
   *
   * @return object Token validé
   */
  protected function validateToken($token)
  {
    try {
      if (preg_match("/Bearer\s(\S+)/", $token, $matches)) {
        $token = $matches[1];
      } else {
        throw new Exception("Token invalide");
      }

      if (isset($token) && $token !== "null") {
        $tokenEncoded = new TokenEncoded($token);
        $tokenEncoded->validate(PUBLIC_KEY, JWT::ALGORITHM_RS256);
      } else {
        throw new Exception("Token invalide ou expiré");
      }
    } catch (Exception $e) {
      echo $this->createResponse(
        "error",
        "Token invalide : " . $e->getMessage(),
        []
      );
      header("HTTP/1.1 401 Unauthorized");
      exit();
    }

    return $tokenEncoded;
  }

  /**
   * Permet de déchiffrer le payload d'un JSON Web Token
   *
   * Nécessite la bibliothèque "php-jwt"
   * https://github.com/nowakowskir/php-jwt
   * Copyright 2019 Nowakowski Radosław
   *
   * @param  string       $token      Token à déchiffrer au format JSON
   *
   * @return string|null  Payload du token déchiffré ou null si le token est invalide
   */
  protected function getTokenPayload($token)
  {
    $payload = null;
    $tokenEncoded = $this->validateToken($token);

    $tokenEncoded && ($payload = $tokenEncoded->decode()->getPayload());

    return $payload;
  }
}
