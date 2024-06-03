<?php
require_once __DIR__ . "/BaseController.controller.php";
require_once __DIR__ . "/../models/managers/PublicationManager.class.php";
require_once __DIR__ . "/../models/managers/FichierManager.class.php";

class ProfilController extends BaseController
{

  private $publicationManager;
  private $fichierManager;

  public function __construct()
  {
    $this->publicationManager = new PublicationManager();
    $this->fichierManager = new FichierManager();
  }
  
  /**
   * Endpoint newPublication
   * 
   * Créé une nouvelle publication
   *
   * @return void
   */
  public function newPublication()
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      try {
        $this->validateToken($_SERVER["HTTP_AUTHORIZATION"]);
      } catch (Exception $e) {
        $responseStatus = "error";
        $responseMessage = "Token invalide : " . $e->getMessage();
        $responseData = [];
        $responseHeader = "HTTP/1.1 401 Unauthorized";
      }
      //  Récupération des données de la requête
      $data = $_POST;
      count($_FILES) > 0 && $data["image"] = $_FILES["image"];

      if ($data) {
        $dataFields = [
          "contenu_publication" => [
            "length" => 1000,
            "type" => "string",
            "escapeHtmlSpecialChars" => true,
            "notNull" => true,
          ],
          "id_utilisateur" => [
            "range" => [
              "min" => 0,
              "max" => 9999999,
            ],
            "type" => "integer",
          ],
          "id_page_profil" => [
            "range" => [
              "min" => 0,
              "max" => 9999999,
            ],
            "type" => "integer",
          ],
        ];

        foreach ($dataFields as $key => $values) {
          ${$key} = isset($data[$key]) ? $data[$key] : "";
          ${$key} = $this->validateInput(${$key}, $key, $values);
        }

        if(isset($data["image"]) && $data["image"] != "null") {
          $image = $data["image"]["error"] === UPLOAD_ERR_OK ? $data["image"] : null;
        }

        $idTypeFichier = null;
        $idFichier = null;
        $savePublication = true;

        if ($image) {
          $idTypeFichier = "IMG";
          $fileExtension = end(explode(".", $_FILES['image']['name']));
          $fileTmpPath = $_FILES['image']['tmp_name'];
          $idFichier = $idTypeFichier . "_" . $id_utilisateur . "_" . time();
          $nomFichier = $_FILES['image']['name'];
          $uploadedImageDir = PROJECT_ROOT_PATH . "/uploadedFiles/" . $id_utilisateur . "/publications/images/";

          if (!is_dir($uploadedImageDir)) {
            mkdir($uploadedImageDir, 0777, true);
          }

          $dest_path = $uploadedImageDir . $idFichier . "." . $fileExtension;

          $urlFichier = SERVER_URL . "uploadedFiles/" . $id_utilisateur . "/publications/images/" . $idFichier . "." . $fileExtension;

          $successfulSave = move_uploaded_file($fileTmpPath, $dest_path);

          if ($successfulSave) {
            try {
              $this->fichierManager->creerFichier($idFichier, $nomFichier, $idTypeFichier, $id_utilisateur, $urlFichier);
              $savePublication = true;
            } catch (Exception $e) {
              $savePublication = false;
              $responseStatus = "error";
              $responseMessage = "Enregistrement dans la base de données échoué : " . $e->getMessage();
              $responseData = [];
              $responseHeader = "HTTP/1.1 500 Internal Server Error";
            }
          } else {
            $savePublication = false;
            $responseStatus = "error";
            $responseMessage = "Enregistrement de l'image échoué.";
            $responseData = [];
            $responseHeader = "HTTP/1.1 500 Internal Server Error";
          }
        }

        if ($savePublication) {
          $this->publicationManager->creerPublication(
            $contenu_publication,
            $id_utilisateur,
            $id_page_profil,
            $id_utilisateur,
            $urlFichier,
          );

          $responseStatus = "success";
          $responseMessage = "Publication créée!";
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

  /**
   * Endpoint getPublications
   *
   * Récupère les publications d'une page de profil
   *
   * @return void
   */
  public function getPublications()
  {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
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
        $dataFields = ["id_utilisateur", "id_page_profil", "limit"];
        $responseData = [];

        foreach ($dataFields as $field) {
          ${$field} = isset($data[$field])
            ? (int) $data[$field]
            : null;
        }

        $listePublications = $this->publicationManager->getAllPublications(
          $id_utilisateur,
          $id_page_profil,
          $limit
        );

        if (count($listePublications) === 0) {
          $responseMessage = "Aucune publication trouvée.";
        } else {
          $responseMessage = "Publications trouvées.";
        }

        $responseStatus = "success";
        $responseData = $listePublications;
        $responseHeader = "HTTP/1.1 200 OK";
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
