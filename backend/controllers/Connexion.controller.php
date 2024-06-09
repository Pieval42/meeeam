<?php
require_once __DIR__ . "/Authentification.controller.php";
require_once __DIR__ . "/../models/managers/RequeteManager.class.php";
require_once __DIR__ . "/../models/managers/PageProfilManager.class.php";
require_once __DIR__ . "/../models/managers/UtilisateurManager.class.php";
require_once __DIR__ . "/../models/managers/VilleManager.class.php";
require_once __DIR__ . "/../models/managers/GenreManager.class.php";
require_once __DIR__ . "/../models/managers/PaysManager.class.php";
require_once __DIR__ . "/../models/managers/ListerManager.class.php";


/**
 * Contrôleur de la connexion des utilisateurs à l'application
 *
 * @author  Pierrick Valentin
 *
 * @since 1.0.0
 */
class ConnexionController extends AuthentificationController
{
  private $requeteManager;
  private $pageProfilManager;
  private $utilisateurManager;
  private $villeManager;
  private $genreManager;
  private $paysManager;
  private $listerManager;


  public function __construct()
  {
    $this->requeteManager = new RequeteManager();
    $this->pageProfilManager = new PageProfilManager();
    $this->utilisateurManager = new UtilisateurManager();
    $this->villeManager = new VilleManager();
    $this->genreManager = new GenreManager();
    $this->paysManager = new PaysManager();
    $this->listerManager = new ListerManager();
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
    $accessToken = null;
    $refreshToken = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!$this->checkRequestLimit($_SERVER["REMOTE_ADDR"])) {
        $responseStatus = "error";
        $responseMessage = "Trop de requêtes. Réessayez plus tard.";
        $responseData = [];
        $responseHeader = "HTTP/1.1 429 Too Many Requests";
      }

      //  Récupération des données de la requête
      $data = $this->getRawRequestBody();

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

          $accessToken = $this->createAccessToken($id_utilisateur, $id_page_profil, $pseudo_utilisateur);

          $refreshToken = $this->createRefreshToken($id_utilisateur);

          $villeUtilisateur = $this->villeManager->getVilleById($utilisateur->getIdVilleUtilisateur());

          $utilisateurDetails = $utilisateur->toArray($utilisateur);
          $genre = $this->genreManager->getGenreById($utilisateur->getIdGenreUtilisateur());
          $genre == false ? $utilisateurDetails["genre"] = null : $utilisateurDetails["genre"] = $genre;
          $utilisateurDetails["ville"] = isset($villeUtilisateur) ? $villeUtilisateur->getNomVille() : null;
          $utilisateurDetails["pays"] = isset($villeUtilisateur) ? $this->paysManager->getPays($villeUtilisateur->getIdPaysVille())->getNomFr() : null;
          $utilisateurDetails["sites_web"] = $this->listerManager->getAllSitesByUtilisateur($id_utilisateur);

          $responseStatus = "success";
          $responseMessage = "Connexion réussie.";
          $responseData = [
            "id_utilisateur" => $id_utilisateur,
            "id_page_profil" => $id_page_profil,
            "pseudo_utilisateur" => $pseudo_utilisateur,
            "details_utilisateur" => $utilisateurDetails
          ];
          $responseHeader = "HTTP/1.1 200 OK";
        } else {
          $responseStatus = "error";
          $responseMessage = "Adresse e-mail et/ou mot de passe incorrect";
          $responseData = [];
          $responseHeader = "HTTP/1.1 200 OK";
        }
      } else {
        $responseStatus = "error";
        $responseMessage = "Mauvaise requête.";
        $responseData = [];
        $responseHeader = "HTTP/1.1 400 Bad Request";
      }
    } elseif ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
      $responseStatus = "success";
      $responseMessage = "";
      $responseData = [];
      $responseHeader = "HTTP/1.1 200 OK";
    } else {
      $responseStatus = "error";
      $responseMessage = "Mauvaise requête.";
      $responseData = [];
      $responseHeader = "HTTP/1.1 400 Bad Request";
    }
    echo $this->createResponse(
      $responseStatus,
      $responseMessage,
      $responseData,
      $accessToken,
      $refreshToken
    );
    header($responseHeader);
  }
}
