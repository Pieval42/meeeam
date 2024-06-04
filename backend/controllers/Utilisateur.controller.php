<?php
require_once __DIR__ . "/BaseController.controller.php";
require_once __DIR__ . "/../models/managers/UtilisateurManager.class.php";

/**
 * Contrôleur permettant de récupérer la liste des utilisateurs de l'application
 *
 * @author  Pierrick Valentin
 *
 * @since 1.0.0
 */
class UtilisateurController extends BaseController
{
  private $utilisateurManager;

  public function __construct()
  {
    $this->utilisateurManager = new UtilisateurManager();
  }

  /**
   * Endpoint getAll
   *
   * Récupére la liste des utilisateurs de l'application selon une chaîne de caractères donnée
   *
   * @return void
   */
  public function getAll()
  {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
      //  Récupération des données de la requête
      $data = $_GET;

      if ($data) {
        try {
          $this->validateToken($_SERVER["HTTP_AUTHORIZATION"]);
        } catch (Exception $e) {
          echo $this->createResponse(
            "error",
            "Token invalide : " . $e->getMessage(),
            []
          );
          header("HTTP/1.1 401 Unauthorized");
          exit();
        }

        $fields = ["search"];
        $response_data = [];

        foreach ($fields as $field) {
          ${$field} = isset($data[$field]) ? $data[$field] : "";
        }

        $listeUtilisateurs = $this->utilisateurManager->searchUtilisateurs(
          $search
        );
        foreach ($listeUtilisateurs as $utilisateur) {
          $response_data[] = (object) [
            "id_utilisateur" => $utilisateur["id_utilisateur"],
            "pseudo_utilisateur" =>
            $utilisateur["pseudo_utilisateur"],
            "prenom_utilisateur" =>
            $utilisateur["prenom_utilisateur"],
            "nom_utilisateur" => $utilisateur["nom_utilisateur"],
          ];
        }
        $response_data = json_encode($response_data);
        echo $this->createResponse(
          "success",
          "Utilisateurs trouvés.",
          $response_data
        );
      } else {
        echo $this->createResponse("error", "Mauvaise requête.", []);
        header("HTTP/1.1 422 Unprocessable Entity");
        exit();
      }
    } elseif ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
      header("HTTP/1.1 200 OK");
    } else {
      echo $this->createResponse("error", "Mauvaise requête.", []);
      header("HTTP/1.1 400 Bad Request");
      exit();
    }
  }

  public function delete()
  {
    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
      try {
        $this->validateToken($_SERVER["HTTP_AUTHORIZATION"]);
      } catch (Exception $e) {
        $responseStatus = "error";
        $responseMessage = "Token invalide : " . $e->getMessage();
        $responseData = [];
        $responseHeader = "HTTP/1.1 401 Unauthorized";
      }

      //  Récupération des données de la requête
      $data = $_GET;

      if ($data) {
        $idUtilisateur = $data["id_utilisateur"];
        $error = false;

        try {
          $this->utilisateurManager->deleteUtilisateur($idUtilisateur);
        } catch (Exception $e) {
          $error = true;
          $responseStatus = "error";
          $responseMessage = $e->getMessage();
          $responseData = [];
          $responseHeader = "HTTP/1.1 500 Internal Server Error";
        }

        if (!$error) {
          $responseStatus = "success";
          $responseMessage = "Utilisateur $idUtilisateur supprimé.";
          $responseData = [];
          $responseHeader = "HTTP/1.1 200 OK";
        }
      } else {
        $responseStatus = "error";
        $responseMessage = "Mauvaise requête";
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
      $responseMessage = "Mauvaise requête";
      $responseData = [];
      $responseHeader = "HTTP/1.1 400 Bad Request";
    }
    echo $this->createResponse(
      $responseStatus,
      $responseMessage,
      $responseData,
    );
    header($responseHeader);
  }
}
