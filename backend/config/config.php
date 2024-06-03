<?php
/**
 *   Configuration générale de l'API
 */

/**
 *   Configuration de la connexion à la base de données (BDD)
 */

$dbHost = "localhost"; // Localisation du serveur de la BDD
$dbName = "test_meeeam"; // Nom de la BDD
$dbCharset = "utf8"; // Type d'encodage de caractère de la BDD
$dbUsername = "root"; // Nom d'utilisateur pour la connexion à la BDD
$dbPassword = "root"; // Mot de passe de connexion à la BDD

/**
 *   Définition des constantes de connexion à la BDD
 */

define(
    "DB_INFOS",
    "mysql:host=" . $dbHost . ";dbname=" . $dbName . ";charset=" . $dbCharset
);
define("DB_USERNAME", $dbUsername);
define("DB_PASSWORD", $dbPassword);

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
