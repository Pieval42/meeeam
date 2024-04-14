<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . 'models/PaysManager.class.php';

class PaysController extends BaseController
{

    private $paysManager;

    public function __construct()
    {
        $this->paysManager = new PaysManager;
    }

    public function pays()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $liste_pays = $this->paysManager->getAllPays();

            echo $this->createResponse(
                'success',
                'Liste de pays chargée',
                $liste_pays
            );
        } elseif($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
        } else {
            echo $this->createResponse('error', 'Mauvaise requête.', []);
            exit;
        }
    }
}
