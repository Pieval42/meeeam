<?php
/**
*   Configuration des en-têtes pour gérer le partage de ressources entre origines multiples
*   (Cross-origin resource sharing => CORS)
*/

header("Access-Control-Allow-Origin: " . FRONT_END_SERVER);
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content, Accept, Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/x-www-form-urlencoded");
?>