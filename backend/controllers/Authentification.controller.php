<?php
require_once __DIR__ . "/BaseController.controller.php";

use Nowakowskir\JWT\Exceptions\InsecureTokenException;
use Nowakowskir\JWT\Exceptions\UndefinedAlgorithmException;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;

class AuthentificationController extends BaseController
{
  public function authentification()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // $accessTokenIsValid = $this->validateToken($_SERVER["HTTP_AUTHORIZATION"]);
      // if ($accessTokenIsValid)
      // {
      //   header("HTTP/1.1 200 OK");
      //   exit();
      // } else {
      $data = json_decode(file_get_contents("php://input"), true);
      if ($data) {
        $dataFields = [
          "id_utilisateur" => [
            "range" => [
              "min" => -1,
              "max" => 9999999,
            ],
            "type" => "integer",
            "notNull" => true,
          ],
          "id_page_profil" => [
            "range" => [
              "min" => -1,
              "max" => 9999999,
            ],
            "type" => "integer",
            "notNull" => true,
          ],
          "pseudo_utilisateur" => [
            "type" => "string",
            "regex" =>
            "/^[a-zA-Z]{1}[0-9A-ZÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒa-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ\-_]{3,19}$/",
            "errorMessage" => "Pseudo invalide.",
          ],
        ];

        foreach ($dataFields as $key => $values) {
          ${$key} = isset($data[$key]) ? $data[$key] : "";
          ${$key} = $this->validateInput(${$key}, $key, $values);
        }

        $oldRefreshToken = isset($data["meeeam_refresh_token"]) ? $data["meeeam_refresh_token"] : null;

        $oldRefreshTokenIsValid = $oldRefreshToken ? $this->validateToken($oldRefreshToken) : false;

        if ($oldRefreshTokenIsValid) {
          $newAccessToken = $this->createAccessToken($id_utilisateur, $id_page_profil, $pseudo_utilisateur);
          $newRefreshToken = $this->createRefreshToken($id_utilisateur);
          header("HTTP/1.1 200 OK");
          echo $this->createResponse(
            "success",
            "Authentification réussie.",
            [
              "id_utilisateur" => $id_utilisateur,
              "id_page_profil" => $id_page_profil,
              "pseudo_utilisateur" => $pseudo_utilisateur,
            ],
            $newAccessToken,
            $newRefreshToken
          );
        } else {
          header("HTTP/1.1 498 Token expired/invalid");
          exit();
        }
        // }
      }
    } elseif ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
      header("HTTP/1.1 200 OK");
    } else {
      header("HTTP/1.1 400 Bad Request");
      exit();
    }
  }

  public function createAccessToken($id_utilisateur, $id_page_profil, $pseudo_utilisateur)
  {
    // Création d'un JSON Web Token pour l'authentification de l'utilisateur
    $accessTokenDecoded = new TokenDecoded(
      [
        "iss" => "meeeam_api",
        "sub" => "access_token",
        "aud" => "meeeam_user",
        "iat" => time(),
        "exp" => time() + 15 * 60,
        "id_utilisateur" => $id_utilisateur,
        "id_page_profil" => $id_page_profil,
        "pseudo_utilisateur" => $pseudo_utilisateur,
      ],
      ["alg" => "RS256", "typ" => "JWT"]
    );
    try {
      $accessTokenEncoded = $accessTokenDecoded->encode(
        PRIVATE_KEY,
        JWT::ALGORITHM_RS256
      );
    } catch (InsecureTokenException $e) {
      echo $this->createResponse("error", $e, []);
      exit();
    } catch (UndefinedAlgorithmException $e) {
      echo $this->createResponse("error", $e, []);
      exit();
    }

    return $accessTokenEncoded->toString();
  }

  public function createRefreshToken($id_utilisateur)
  {
    // Création d'un refresh token pour maintenir la connexion d'un utilisateur sur un appareil
    $refreshTokenDecoded = new TokenDecoded(
      [
        "iss" => "meeeam_api",
        "sub" => "refresh",
        "aud" => "meeeam_user",
        "iat" => time(),
        "exp" => time() + 24 * 60 * 60,
        "id_utilisateur" => $id_utilisateur,
      ],
      ["alg" => "RS256", "typ" => "JWT"]
    );
    try {
      $refreshTokenEncoded = $refreshTokenDecoded->encode(
        PRIVATE_KEY,
        JWT::ALGORITHM_RS256
      );
    } catch (InsecureTokenException $e) {
      echo $this->createResponse("error", $e, []);
      exit();
    } catch (UndefinedAlgorithmException $e) {
      echo $this->createResponse("error", $e, []);
      exit();
    }

    return $refreshTokenEncoded->toString();
  }
}
