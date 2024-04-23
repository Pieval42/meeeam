<?php
require_once __DIR__ . "/BaseController.controller.php";
require_once __DIR__ . "/../models/managers/PaysManager.class.php";

/**
 * Contrôleur permettant de récupérer la liste de pays
 *
 * @author  Pierrick Valentin
 *
 * @since 1.0.0
 *
 */
class PaysController extends BaseController
{
    private $paysManager;

    public function __construct()
    {
        $this->paysManager = new PaysManager();
    }

    /**
     * Endpoint pays
     *
     * Permet de récupérer la liste de pays
     *
     * @return void
     */
    public function pays()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $liste_pays = $this->paysManager->getAllPays();

            echo $this->createResponse(
                "success",
                "Liste de pays chargée",
                $liste_pays
            );
        } elseif ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
            exit();
        }
    }
}
?>
