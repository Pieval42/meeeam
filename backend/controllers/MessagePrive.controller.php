<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . 'models/managers/MessagePriveManager.class.php';
require_once __DIR__ . "/../" . 'models/managers/UtilisateurManager.class.php';

class MessagePriveController extends BaseController
{
    private $messagePriveManager;
    private $utilisateurManager;

    public function __construct()
    {
        $this->messagePriveManager = new MessagePriveManager;
        $this->utilisateurManager = new UtilisateurManager;
    }

    private function getPseudos($id_expediteur_prive, $id_destinataire_prive)
    {
        $pseudo_expediteur = $this->utilisateurManager->getUtilisateurById($id_expediteur_prive)->getPseudoUtilisateur();
        $pseudo_destinataire = $this->utilisateurManager->getUtilisateurById($id_destinataire_prive)->getPseudoUtilisateur();
        return ['pseudo_expediteur' => $pseudo_expediteur, 'pseudo_destinataire' => $pseudo_destinataire];
    }

    public function envoyerMessagePrive()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $tokenPayload = $this->getTokenPayload($_SERVER["HTTP_AUTHORIZATION"]);

            $data = json_decode(file_get_contents('php://input'), true);
            if ($data) {

                $dataFields = ['id_expediteur_prive', 'contenu_message', 'id_destinataire_prive'];

                foreach ($dataFields as $field) {
                    ${$field} = isset($data[$field]) ? $data[$field] : '';
                    if (!$this->validateInput(${$field})) {
                        echo $this->createResponse('error', 'Informations incorrectes.');
                        exit;
                    }
                }

                if($id_expediteur_prive === $tokenPayload['id_utilisateur']) {
                    $messagePrive = $this->messagePriveManager->creerMessagePrive($id_expediteur_prive, $contenu_message, $id_destinataire_prive);
                    $id_message_prive = $messagePrive->getIdMessagePrive();
                    $pseudos = $this->getPseudos($id_expediteur_prive, $id_destinataire_prive);
                    $date_heure_message = $messagePrive->getDateHeureMessage();
                    
    
                    echo $this->createResponse(
                        'success',
                        "Message envoyé.",
                        [
                            'id_message_prive' => $id_message_prive,
                            'id_expediteur_prive' => $id_expediteur_prive,
                            'pseudo_expediteur' => $pseudos['pseudo_expediteur'],
                            'contenu_message' => $contenu_message,
                            'id_destinataire_prive' => $id_destinataire_prive,
                            'pseudo_destinataire' => $pseudos['pseudo_destinataire'],
                            'date_heure_message' => $date_heure_message
                        ]
                    );
                } else {
                    echo $this->createResponse('error', "Erreur d'authentification", []);
                    exit;
                }

            } else {
                echo $this->createResponse('error', 'Contenu de la requête invalide.', []);
                exit;
            }
        } elseif($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
        } else {
            echo $this->createResponse('error', 'Mauvaise requête.', []);
            exit;
        }
    }

    public function getMessagesPrives()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $tokenPayload = $this->getTokenPayload($_SERVER["HTTP_AUTHORIZATION"]);

            $data = $_GET;
            if ($data) {

                $dataFields = ['id_utilisateur', 'id_utilisateur_2', 'limit'];
                $response_data = [];

                foreach ($dataFields as $field) {
                    ${$field} = isset($data[$field]) ? intval($data[$field]) : null;
                }
                
                if($id_utilisateur === $tokenPayload['id_utilisateur']) {

                    if($id_utilisateur_2) {
                        $liste_messages_prives = $this->messagePriveManager->getConversation($id_utilisateur, $id_utilisateur_2, $limit);
                        $i = 0;
                        foreach($liste_messages_prives as $message) {
                            $pseudos = $this->getPseudos($message['id_expediteur_prive'], $message['id_destinataire_prive']);
                            $liste_messages_prives[$i]['pseudo_expediteur'] = $pseudos['pseudo_expediteur'];
                            $liste_messages_prives[$i]['pseudo_destinataire'] = $pseudos['pseudo_destinataire'];
                            $i++;
                        }
                        $response_data = $liste_messages_prives;
                    } else {
                        $liste_messages_prives = $this->messagePriveManager->getAllMessagePrives($id_utilisateur, $limit);
                        $i = 0;
        
                        foreach($liste_messages_prives as $message) {
                            $pseudos = $this->getPseudos($message['id_expediteur_prive'], $message['id_destinataire_prive']);
                            $response_data[$i] = ['pseudo_expediteur' => $pseudos['pseudo_expediteur'], 'id_expediteur' => $message['id_expediteur_prive'], 'pseudo_destinataire' => $pseudos['pseudo_destinataire'], 'id_destinataire' => $message['id_destinataire_prive']];
                            $i++;
                        }
                        
                    }
    
                    if(count($liste_messages_prives) === 0) {
                        $response_message = "Aucun message";
                    } else {
                        $response_message = "Messages trouvés.";
                    }
                    echo $this->createResponse(
                        'success',
                        $response_message,
                        $response_data
                    );
                } else {
                    echo $this->createResponse('error', "Erreur d'authentification", []);
                    exit;
                }

            } else {
                echo $this->createResponse('error', 'Mauvaise requête.', []);
                exit;
            }
        } elseif($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
        } else {
            echo $this->createResponse('error', 'Mauvaise requête.', []);
            exit;
        }
    }
}

