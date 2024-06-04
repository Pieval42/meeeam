<?php
/**
 *   Configuration générale de l'API
 */

/**
 *   Définition de la localisation du dossier racine du projet
 */

define("PROJECT_ROOT_PATH", "C:\wamp64\www\meeeam\backend");

/**
 *  Définition de l'url du serveur de l'API
 */
$serverUrl = "http://localhost/meeeam/backend/";
define("SERVER_URL", $serverUrl);

/**
 *   Définition du port du serveur de l'API
 */

$serverPort = "42600";
define("SERVER_PORT", $serverPort);

/**
 *   Définition de l'adresse du serveur de l'interface web
 */

$frontEndServer = "http://localhost:8080";
define("FRONT_END_SERVER", $frontEndServer);

/**
 *   Récupération des clés privée et publique servant au chiffrement de la signature des JWT
 */

try {
    $privateKey = file_get_contents("C:/Users/pieva/.ssh/private.pem");
    define("PRIVATE_KEY", $privateKey);

    $publicKey = file_get_contents("C:/Users/pieva/.ssh/public.pem");
    define("PUBLIC_KEY", $publicKey);
} catch (Exception $e) {
    error_log($e->getMessage(), 0);
}
?>
