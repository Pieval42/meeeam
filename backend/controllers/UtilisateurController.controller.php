<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . '/models/UtilisateurManager.class.php';

class UtilisateurController extends BaseController
{
    private $utilisateurManager;

    public function __construct(){
        $this->utilisateurManager = new UtilisateurManager;
    }

    /** 
    * "/user/list" Endpoint - Get list of users 
    */

    public function listeUtilisateurs()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUtilisateurs = $this->utilisateurManager->getAllUtilisateurs($intLimit);
                $responseData = json_encode($arrUtilisateurs);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage()."Une erreur est survenue. Veuillez contacter l'assistance.";
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Méthode de requête inconnue';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function connexion()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $arrUtilisateurs = $this->utilisateurManager->getAllUtilisateurs(null);
                $responseData = json_encode($arrUtilisateurs);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage()."Une erreur est survenue. Veuillez contacter l'assistance.";
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Méthode de requête inconnue';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // comparer les données envoyées avec celles de la BDD

        // $email = ;

        foreach($arrUtilisateurs as $utilisateur) {

        }

        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}