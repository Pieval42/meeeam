<?php
require_once __DIR__ . "/BaseController.controller.php";
require_once __DIR__ . "/../models/managers/MessagePriveManager.class.php";
require_once __DIR__ . "/../models/managers/UtilisateurManager.class.php";

/**
 * Contrôleur de gestion des messages privés des utilisateurs
 *
 * @author  Pierrick Valentin
 *
 * @since 1.0.0
 *
 */
class MessagePriveController extends BaseController
{
  private $messagePriveManager;
  private $utilisateurManager;

  public function __construct()
  {
    $this->messagePriveManager = new MessagePriveManager();
    $this->utilisateurManager = new UtilisateurManager();
  }

  /**
   * Récupère les pseudos du destinataire et de l'expéditeur grâce à leurs ids respectifs
   *
   * @param  int  $id_expediteur_prive
   * @param  int  $id_destinataire_prive
   *
   * @return void
   */
  private function getPseudos($id_expediteur_prive, $id_destinataire_prive)
  {
    $pseudo_expediteur = $this->utilisateurManager
      ->getUtilisateurById($id_expediteur_prive)
      ->getPseudoUtilisateur();
    $pseudo_destinataire = $this->utilisateurManager
      ->getUtilisateurById($id_destinataire_prive)
      ->getPseudoUtilisateur();
    return [
      "pseudo_expediteur" => $pseudo_expediteur,
      "pseudo_destinataire" => $pseudo_destinataire,
    ];
  }

  /**
   * Endpoint envoyerMessagePrive
   *
   * Permet à un utilisateur d'envoyer un message à un autre utilisateur
   *
   * @return void
   */
  public function envoyerMessagePrive()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      //  Récupération des données de la requête
      $data = $this->getRawRequestBody();

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

        $dataFields = [
          "id_expediteur_prive" => [
            "range" => [
              "min" => 0,
              "max" => 9999999,
            ],
            "type" => "integer",
          ],
          "contenu_message" => [
            "length" => 500,
            "type" => "string",
            "escapeHtmlSpecialChars" => true,
          ],
          "id_destinataire_prive" => [
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

        $messagePrive = $this->messagePriveManager->creerMessagePrive(
          $id_expediteur_prive,
          $contenu_message,
          $id_destinataire_prive
        );
        $id_message_prive = $messagePrive->getIdMessagePrive();
        $pseudos = $this->getPseudos(
          $id_expediteur_prive,
          $id_destinataire_prive
        );
        $date_heure_message = $messagePrive->getDateHeureMessage();

        echo $this->createResponse("success", "Message envoyé.", [
          "id_message_prive" => $id_message_prive,
          "id_expediteur_prive" => $id_expediteur_prive,
          "pseudo_expediteur" => $pseudos["pseudo_expediteur"],
          "contenu_message" => $contenu_message,
          "id_destinataire_prive" => $id_destinataire_prive,
          "pseudo_destinataire" => $pseudos["pseudo_destinataire"],
          "date_heure_message" => $date_heure_message,
        ]);
      } else {
        echo $this->createResponse(
          "error",
          "Contenu de la requête invalide.",
          []
        );
        exit();
      }
    } elseif ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
      header("HTTP/1.1 200 OK");
    } else {
      header("HTTP/1.1 400 Bad Request");
      exit();
    }
  }

  /**
   * Endpoint getMessagePrive
   *
   * Récupère les messages privés d'un utilisateur en filtrant éventuellement ceux d'un correspondant précis
   *
   * @return void
   */
  public function getMessagePrive()
  {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
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

      //  Récupération des données de la requête
      $data = $_GET;

      if ($data) {
        $dataFields = ["id_utilisateur", "id_utilisateur_2", "limit"];
        $response_data = [];

        foreach ($dataFields as $field) {
          ${$field} = isset($data[$field])
            ? (int) $data[$field]
            : null;
        }

        if ($id_utilisateur_2) {
          //  Filtre les messages d'un unique correspondant si celui-ci est précisé dans la requête
          $liste_messages_prives = $this->messagePriveManager->getConversation(
            $id_utilisateur,
            $id_utilisateur_2,
            $limit
          );
          $i = 0;
          foreach ($liste_messages_prives as $message) {
            $pseudos = $this->getPseudos(
              $message["id_expediteur_prive"],
              $message["id_destinataire_prive"]
            );
            $liste_messages_prives[$i]["pseudo_expediteur"] =
              $pseudos["pseudo_expediteur"];
            $liste_messages_prives[$i]["pseudo_destinataire"] =
              $pseudos["pseudo_destinataire"];
            $i++;
          }
          $response_data = $liste_messages_prives;
        } else {
          //  Récupère tous les messages d'un utilisateur
          $liste_messages_prives = $this->messagePriveManager->getAllMessagePrives(
            $id_utilisateur,
            $limit
          );

          $i = 0;
          foreach ($liste_messages_prives as $message) {
            $pseudos = $this->getPseudos(
              $message["id_expediteur_prive"],
              $message["id_destinataire_prive"]
            );
            $liste_messages_prives[$i]["pseudo_expediteur"] =
              $pseudos["pseudo_expediteur"];
            $liste_messages_prives[$i]["pseudo_destinataire"] =
              $pseudos["pseudo_destinataire"];
            $i++;
          }

          $response_data = $liste_messages_prives;
        }

        if (count($liste_messages_prives) === 0) {
          $response_message = "Aucun message";
        } else {
          $response_message = "Messages trouvés.";
        }

        header("HTTP/1.1 200 OK");

        echo $this->createResponse(
          "success",
          $response_message,
          $response_data
        );
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
