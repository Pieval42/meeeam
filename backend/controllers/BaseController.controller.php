<?php

require_once __DIR__ . "/../" . '/config/config.php';
require_once __DIR__ . "/../" . '/config/config_requetes.php';
require_once __DIR__ . "/../" . '/models/RequeteManager.class.php';

class BaseController
{
    private $requeteManager;

    public function __construct(){
        $this->requeteManager = new RequeteManager;
    }

    /** 
     * __call magic method. 
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
    /** 
     * Get URI elements. 
     * 
     * @return array 
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri;
    }
    /** 
     * Get querystring params. 
     * 
     * @return array 
     */
    protected function getQueryStringParams()
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            return parse_str($_SERVER['QUERY_STRING'], $query);
        }
    }
    /** 
     * Send API output. 
     * 
     * @param mixed $data 
     * @param string $httpHeader 
     */
    protected function sendOutput($data, $httpHeaders = array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }

    //Output values
    protected function createResponse($status, $message, $data = [])
    {
        $response =
        [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
        return json_encode($response);
    }

    protected function validateInput($input)
    {
        //SQL Injection protection
        if (preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $input)) {
            return false;
        }

        // XSS protection
        if (preg_match('/<[^>]*>/', $input)) {
            return false;
        }

        return true;
    }

    protected function checkRequestLimit($adresse_ip) {
        $this->requeteManager = new RequeteManager;
        $requetes = $this->requeteManager->getNbRequetesByIp($adresse_ip);

        //Maximum 100 requetes/heure
        if (count($requetes) > 100) {
            return false;
        }

        return true;
    }

     //Limitation of access time
     protected function checkRequestTime($adresse_ip) {
        $this->requeteManager = new RequeteManager;
        $requete = $this->requeteManager->getHeureRequeteByIp($adresse_ip);
        if ($requete) {
            $heure_derniere_requete = strtotime($requete['date_heure_req']);
            $heure_actuelle = strtotime(date('Y-m-d H:i:s'));
            if ($heure_actuelle - $heure_derniere_requete < 1) {
                return false;
            }
        }

        return true;
    }

    //Encrypt
    protected function xorEncrypt($input)
    {

        return base64_encode($input);
    }
}
