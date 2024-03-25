<?php
require_once __DIR__ . "/config/config_requetes.php";
require __DIR__ . "/config/config.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if ((isset($uri[3]) && $uri[3] != ('listeUtilisateurs' || 'connexion' || 'inscription'))) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
if($uri[3] == 'listeUtilisateurs') {
    require PROJECT_ROOT_PATH . "/controllers/UtilisateurController.controller.php";
    $objFeedController = new UtilisateurController();
    $strMethodName = $uri[3];
    $objFeedController->{$strMethodName}();
}
if($uri[3] == 'connexion') {
    require PROJECT_ROOT_PATH . "/controllers/Requete.controller.php";
    $objFeedController = new RequeteController();
    $strMethodName = $uri[3];
    $objFeedController->{$strMethodName}();
}
if($uri[3] == 'inscription') {
    require PROJECT_ROOT_PATH . "/controllers/Inscription.controller.php";
    $objFeedController = new InscriptionController();
    $strMethodName = $uri[3];
    $objFeedController->{$strMethodName}();
}
?>