<?php
require_once __DIR__ . "/BaseController.controller.php";
require_once __DIR__ . "/../models/managers/PageProfilManager.class.php";
require_once __DIR__ . "/../models/managers/UtilisateurManager.class.php";
require_once __DIR__ . "/../models/managers/RequeteManager.class.php";
require_once __DIR__ . "/../models/managers/VilleManager.class.php";
require_once __DIR__ . "/../models/managers/SiteWebManager.class.php";
require_once __DIR__ . "/../models/managers/ListerManager.class.php";

/**
 * Contrôleur de gestion des inscriptions des utilisateurs
 *
 * @author  Pierrick Valentin
 *
 * @since 1.0.0
 */
class InscriptionController extends BaseController
{
  private $pageProfilManager;
  private $utilisateurManager;
  private $requeteManager;
  private $villeManager;
  private $siteWebManager;
  private $listerManager;

  public function __construct()
  {
    $this->pageProfilManager = new PageProfilManager();
    $this->utilisateurManager = new UtilisateurManager();
    $this->requeteManager = new RequeteManager();
    $this->villeManager = new VilleManager();
    $this->siteWebManager = new SiteWebManager();
    $this->listerManager = new ListerManager();
  }

  /**
   * Endpoint inscription
   *
   * Permet à un utilisateur de s'inscrire grâce aux informations qu'il fournit via un formulaire
   *
   * Données requises : "pseudo", "email", "password", "prenom", "nom", "date_de_naissance"
   * Données optionnelles : "id_genre", "code_postal", "nom_ville", "id_pays", "site_web"
   *
   * @return void
   */
  public function inscription()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!$this->checkRequestLimit($_SERVER["REMOTE_ADDR"])) {
        echo $this->createResponse(
          "error",
          "Too many requests! Try again later."
        );
        exit();
      }

      // if (!$this->checkRequestTime($_SERVER["REMOTE_ADDR"])) {
      //     echo $this->createResponse("error", "Request too common! Try again later.");
      //     exit;
      // }

      //  Récupération des données de la requête
      $data = json_decode(file_get_contents("php://input"), true);

      if ($data) {
        try {
          $dataFields = [
            "pseudo" => [
              "type" => "string",
              "regex" =>
              "/^[a-zA-Z]{1}[0-9A-ZÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒa-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ\-_]{3,19}$/",
              "errorMessage" => "Pseudo invalide. Votre pseudo doit commencer par une lettre et peut contenir des lettres, des chiffres et les symboles - et _ uniquement.
                                                Longueur exigée entre 4 et 20 caractères.",
              "notNull" => true,
            ],
            "email" => [
              "type" => "email",
              "length" => 50,
              "notNull" => true,
            ],
            "password" => [
              "type" => "string",
              "regex" =>
              "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\&\~\"\#\'\{\(\[\-\|\`\_\\\ç\^\@\)\]\=\°\+\}¨\$£¤%\*µ\<\>,?;.:\/!§éèçàù]).{10,64}$/",
              "errorMessage" => "Mot de passe trop faible. Votre mot de passe doit contenir au moins 10 caractères,
                                                dont au moins une minuscule, une majuscule, un chiffre et un caractère spécial.",
              "notNull" => true,
            ],
            "prenom" => [
              "type" => "string",
              "length" => 50,
              "regex" =>
              "/^[A-ZÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒa-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ\'\-\s]{1,50}$/",
              "notNull" => true,
            ],
            "nom" => [
              "type" => "string",
              "length" => 50,
              "regex" =>
              "/^[A-ZÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒa-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ\'\-\s]{1,50}$/",
              "notNull" => true,
            ],
            "date_de_naissance" => [
              "type" => "date",
              "notNull" => true,
            ],
            "id_genre" => [
              "type" => "string",
              "regex" => "/^[HFNI]{1}$/",
              "notNull" => false,
            ],
            "code_postal" => [
              "type" => "string",
              "regex" => "/^[a-zA-Z0-9\-]{2,10}$/",
              "notNull" => false,
            ],
            "nom_ville" => [
              "type" => "string",
              "regex" =>
              "/^[A-ZÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒa-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ\'\-\s]{1,60}$/",
              "notNull" => false,
            ],
            "id_pays" => [
              "type" => "integer",
              "range" => [
                "min" => 0,
                "max" => 238,
              ],
              "notNull" => false,
            ],
            "site_web" => [
              "type" => "url",
              "length" => 100,
              "notNull" => false,
            ],
          ];

          // $requiredFields = ["pseudo", "email", "password", "prenom", "nom", "date_de_naissance"];

          foreach ($dataFields as $key => $values) {
            ${$key} = isset($data[$key]) ? $data[$key] : "";
            ${$key} = $this->validateInput(${$key}, $key, $values);
          }

          // foreach ($requiredFields as $field) {
          //     if (empty($field)) {
          //         echo $this->createResponse("error", "Champs requis manquants.");
          //         exit;
          //     }
          // }

          $encrypted_password = password_hash(
            $password,
            PASSWORD_DEFAULT
          );

          $id_pays === 0 && ($id_pays = null);
          $id_ville = null;

          if ($nom_ville && $code_postal && $id_pays) {
            $ville = $this->villeManager->getVille(
              $nom_ville,
              $code_postal
            );
            if ($ville) {
              $id_ville = $ville->getIdVille();
            } else {
              $ville = $this->villeManager->creerVille(
                $nom_ville,
                $code_postal,
                $id_pays
              );
              $id_ville = $ville->getIdVille();
            }
          } elseif ($nom_ville && !$code_postal && !$id_pays) {
            echo $this->createResponse(
              "error",
              "Code postal et pays de la ville manquant."
            );
            exit();
          } elseif (!$nom_ville && $code_postal && !$id_pays) {
            echo $this->createResponse(
              "error",
              "Nom et pays de la ville manquant."
            );
            exit();
          } elseif (!$nom_ville && !$code_postal && $id_pays) {
            echo $this->createResponse(
              "error",
              "Nom et code postal de la ville manquant."
            );
            exit();
          } elseif ($nom_ville && $code_postal && !$id_pays) {
            echo $this->createResponse(
              "error",
              "Pays de la ville manquant."
            );
            exit();
          } elseif (!$nom_ville && $code_postal && $id_pays) {
            echo $this->createResponse(
              "error",
              "Nom de la ville manquant."
            );
            exit();
          } elseif ($nom_ville && !$code_postal && $id_pays) {
            echo $this->createResponse(
              "error",
              "Code postal de la ville manquant."
            );
            exit();
          }

          $utilisateur = $this->utilisateurManager->creerUtilisateur(
            $pseudo,
            $nom,
            $prenom,
            $date_de_naissance,
            $email,
            $encrypted_password,
            $id_genre,
            $id_ville
          );
          $id_utilisateur = $utilisateur->getIdUtilisateur();
          if ($site_web !== "") {
            $site_web = strpos($site_web, 'http') !== 0 ? "http://$site_web" : $site_web;
            $this->siteWebManager->creerSiteWeb($site_web);
            $this->listerManager->creerCorrespondance(
              $id_utilisateur,
              $site_web
            );
          }
          $this->pageProfilManager->creerPageProfil($id_utilisateur);
          $this->requeteManager->creerRequete(
            $id_utilisateur,
            $_SERVER["REMOTE_ADDR"],
            $encrypted_password,
            $email,
            "inscription"
          );

          echo $this->createResponse(
            "success",
            "Votre compte a été crée avec succès! Vous allez être redirigé vers l'accueil.",
            [
              "pseudo" => $pseudo,
              "password" => $encrypted_password,
              "email" => $email,
              "id_page_profil" => $this->pageProfilManager->getPageProfilByIdUtilisateur(
                $id_utilisateur
              ),
            ]
          );
        } catch (Exception $e) {
          echo $this->createResponse("error", $e->getMessage());
          exit();
        }
      } else {
        echo $this->createResponse("error", "Mauvaise requête.");
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
