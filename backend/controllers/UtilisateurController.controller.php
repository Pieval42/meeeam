<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . '/models/UtilisateurManager.class.php';

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

                $fields = ['search'];
                $response_data = [];

                foreach ($fields as $field) {
                    ${$field} = isset($data[$field]) ? $data[$field] : "";
                }

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
                echo $this->createResponse('error', 'Mauvaise requête.', []);
                header('HTTP/1.1 422 Unprocessable Entity');
                exit;
            }
        } else {
            echo $this->createResponse('error', 'Mauvaise requête.', []);
            header('HTTP/1.1 422 Unprocessable Entity');
            exit;
        }
    }

    // public function listeUtilisateurs()
    // {
    //     $strErrorDesc = '';
    //     $requestMethod = $_SERVER["REQUEST_METHOD"];
    //     $arrQueryStringParams = $this->getQueryStringParams();
    //     if (strtoupper($requestMethod) == 'GET') {
    //         try {
    //             $intLimit = 10;
    //             if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
    //                 $intLimit = $arrQueryStringParams['limit'];
    //             }
    //             $listeUtilisateurs = $this->utilisateurManager->getAllUtilisateurs($intLimit);
    //             $responseData = json_encode($listeUtilisateurs);
    //         } catch (Error $e) {
    //             $strErrorDesc = $e->getMessage()."Une erreur est survenue. Veuillez contacter l'assistance.";
    //             $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    //         }
    //     } else {
    //         $strErrorDesc = 'Méthode de requête inconnue';
    //         $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
    //     }
    //     // send output 
    //     if (!$strErrorDesc) {
    //         $this->sendOutput(
    //             $responseData,
    //             array('Content-Type: application/json', 'HTTP/1.1 200 OK')
    //         );
    //     } else {
    //         $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
    //             array('Content-Type: application/json', $strErrorHeader)
    //         );
    //     }
    // }

    public function connexion()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $listeUtilisateurs = $this->utilisateurManager->getAllUtilisateurs(null);
                $responseData = json_encode($listeUtilisateurs);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . "Une erreur est survenue. Veuillez contacter l'assistance.";
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Méthode de requête inconnue';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // comparer les données envoyées avec celles de la BDD

        // $email = ;

        foreach ($listeUtilisateurs as $utilisateur) {
        }

        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
