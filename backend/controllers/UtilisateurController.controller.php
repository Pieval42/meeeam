<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . '/models/managers/UtilisateurManager.class.php';

class UtilisateurController extends BaseController
{
    private $utilisateurManager;

    public function __construct()
    {
        $this->utilisateurManager = new UtilisateurManager;
    }

    /** 
     * "/user/list" Endpoint - Get list of users 
     */

    public function listeUtilisateurs()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $data = $_GET;
            if ($data) {

                $tokenPayload = $this->getTokenPayload($_SERVER["HTTP_AUTHORIZATION"]);

                $fields = ['search'];
                $response_data = [];

                foreach ($fields as $field) {
                    ${$field} = isset($data[$field]) ? $data[$field] : "";
                }

                if($tokenPayload['id_utilisateur']) {
                    try {
                        $listeUtilisateurs = $this->utilisateurManager->searchUtilisateurs($search);
                        foreach ($listeUtilisateurs as $utilisateur) {
                            $response_data[] = (object)[
                                'id_utilisateur' => $utilisateur['id_utilisateur'],
                                'pseudo_utilisateur' => $utilisateur['pseudo_utilisateur'],
                                'prenom_utilisateur' => $utilisateur['prenom_utilisateur'],
                                'nom_utilisateur' => $utilisateur['nom_utilisateur'],
                            ];
                        }
                        $response_data = json_encode($response_data);
                        echo $this->createResponse(
                            'success',
                            'Utilisateurs trouvés.',
                            $response_data
                        );
                    } catch (Exception $e) {
                        echo $this->createResponse(
                            'error',
                            "Une erreur est survenue. Veuillez contacter l'assistance.",
                            [],
                        );
                        header('HTTP/1.1 500 Internal Server Error');
                    }
                } else {
                    echo $this->createResponse('error', "Erreur d'authentification", []);
                    exit;
                }
            } else {
                echo $this->createResponse('error', 'Mauvaise requête.', []);
                header('HTTP/1.1 422 Unprocessable Entity');
                exit;
            }
        } elseif($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
        } else {
            echo $this->createResponse('error', 'Mauvaise requête.', []);
            header('HTTP/1.1 422 Unprocessable Entity');
            exit;
        }
    }
}
