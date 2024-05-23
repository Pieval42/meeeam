<?php
require_once __DIR__ . "/BaseController.controller.php";
require_once __DIR__ . "/../models/managers/RequeteManager.class.php";
require_once __DIR__ . "/../models/managers/PageProfilManager.class.php";
require_once __DIR__ . "/../models/managers/UtilisateurManager.class.php";

use Nowakowskir\JWT\Exceptions\InsecureTokenException;
use Nowakowskir\JWT\Exceptions\UndefinedAlgorithmException;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;

/**
 * Contrôleur de la connexion des utilisateurs à l'application
 *
 * @author  Pierrick Valentin
 *
 * @since 1.0.0
 */
class ConnexionController extends BaseController
{
  private $requeteManager;
  private $pageProfilManager;
  private $utilisateurManager;

  public function __construct()
  {
    $this->requeteManager = new RequeteManager();
    $this->pageProfilManager = new PageProfilManager();
    $this->utilisateurManager = new UtilisateurManager();
  }

  /**
   * Endpoint connexion
   *
   * Permet à un utilisateur de se connecter à l'application grâce à son email et son mot de passe
   * en effectuant les vérifications nécessaires
   *
   * @return void
   */
  public function connexion()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!$this->checkRequestLimit($_SERVER["REMOTE_ADDR"])) {
        echo $this->createResponse(
          "error",
          "Too many requests! Try again later.",
          []
        );
        exit();
      }

      // if (!$this->checkRequestTime($_SERVER['REMOTE_ADDR'])) {
      //     echo $this->createResponse('error', 'Request too common! Try again later.', []);
      //     exit;
      // }

      //  Récupération des données de la requête
      $data = json_decode(file_get_contents("php://input"), true);

      if ($data) {
        $email = isset($data["email"]) ? $data["email"] : "";
        $mot_de_passe = isset($data["mot_de_passe"])
          ? $data["mot_de_passe"]
          : "";

        if (empty($data["email"]) || empty($data["mot_de_passe"])) {
          echo $this->createResponse(
            "error",
            "Champs requis manquants."
          );
          exit();
        }
        $utilisateur = $this->utilisateurManager->getUtilisateurByEmail(
          $email
        );

        $mot_de_passe_hash = password_hash(
          $mot_de_passe,
          PASSWORD_DEFAULT
        );

        $this->requeteManager->creerRequete(
          $utilisateur ? $utilisateur->getIdUtilisateur() : null,
          $_SERVER["REMOTE_ADDR"],
          $mot_de_passe_hash,
          $email,
          "connexion"
        );

        $requete = $this->requeteManager->getRequetesByEmail($email);

        $mot_de_passe_utilisateur = $utilisateur
          ? $utilisateur->getMotDePasse()
          : null;

        if (password_verify($mot_de_passe, $mot_de_passe_utilisateur)) {
          $id_utilisateur = $requete["id_utilisateur_req"];
          $id_page_profil = $this->pageProfilManager->getPageProfilByIdUtilisateur(
            $id_utilisateur
          );
          $pseudo_utilisateur = $utilisateur->getPseudoUtilisateur();

          // Création d'un JSON Web Token pour l'authentification de l'utilisateur
          $accessTokenDecoded = new TokenDecoded(
            [
              "iss" => "meeeam_api",
              "sub" => "access_token",
              "aud" => "meeeam_user",
              "iat" => time(),
              "exp" => time() + 30 * 60,
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

          $accessToken = $accessTokenEncoded->toString();

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

          $refreshToken = $refreshTokenEncoded->toString();

          echo $this->createResponse(
            "success",
            "Connexion réussie.",
            [
              "id_utilisateur" => $id_utilisateur,
              "id_page_profil" => $id_page_profil,
              "pseudo_utilisateur" => $pseudo_utilisateur,
            ],
            $accessToken,
            $refreshToken
          );
        } else {
          echo $this->createResponse(
            "error",
            "Adresse e-mail et/ou mot de passe incorrect"
          );
          exit();
        }
      } else {
        echo $this->createResponse("error", "Mauvaise requête.", []);
        exit();
      }
    } elseif ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
      header("HTTP/1.1 200 OK");
    } else {
      header("HTTP/1.1 400 Bad Request");
      exit();
    }
  }
}
