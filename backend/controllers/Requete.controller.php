<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . '/models/RequeteManager.class.php';
require_once __DIR__ . "/../" . '/models/PageProfilManager.class.php';
require_once __DIR__ . "/../" . '/models/UtilisateurManager.class.php';

class RequeteController extends BaseController
{
    private $requeteManager;
    private $pageProfilManager;
    private $utilisateurManager;

    public function __construct(){
        $this->requeteManager = new RequeteManager;
        $this->pageProfilManager = new PageProfilManager;
        $this->utilisateurManager = new UtilisateurManager;
    }

    //Processing API requests
    public function connexion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!$this->checkRequestLimit($_SERVER['REMOTE_ADDR'])) {
                echo $this->createResponse('error', 'Too many requests! Try again later.', []);
                exit;
            }

            // if (!$this->checkRequestTime($_SERVER['REMOTE_ADDR'])) {
            //     echo $this->createResponse('error', 'Request too common! Try again later.', []);
            //     exit;
            // }

            //Check and process entered data
            $data = json_decode(file_get_contents('php://input'), true);
            if ($data) {

                $email = isset($data['email']) ? $data['email'] : '';
                $mot_de_passe = isset($data['mot_de_passe']) ? $data['mot_de_passe'] : '';

                if (empty($data['email']) || empty($data['mot_de_passe'])) {
                    echo $this->createResponse('error', 'Champs requis manquants.', []);
                    exit;
                }
                $utilisateur = $this->utilisateurManager->getUtilisateurByEmail($email);

                $mot_de_passe_hash = password_hash(
                    $mot_de_passe,
                    PASSWORD_DEFAULT
                );

                $this->requeteManager->creerRequete($utilisateur->getIdUtilisateur(), $_SERVER['REMOTE_ADDR'], $mot_de_passe_hash, $email, "connexion");

                $requete = $this->requeteManager->getRequetesByEmail($email);

                $mot_de_passe_utilisateur = $utilisateur->getMotDePasse();

                if (password_verify($mot_de_passe, $mot_de_passe_utilisateur)) {
                    session_start();
                    $id_utilisateur = $requete['id_utilisateur_req'];
                    $id_page_profil = $this->pageProfilManager->getPageProfilByIdUtilisateur($id_utilisateur);
                    $pseudo_utilisateur = $utilisateur->getPseudoUtilisateur();
                    $_SESSION['id_utilisateur'] = $id_utilisateur;
                    
                    echo $this->createResponse('success', 'Connexion réussie.', ['id_utilisateur_req' => $_SESSION['id_utilisateur'], 'id_page_profil' => $id_page_profil, 'pseudo_utilisateur' => $pseudo_utilisateur]);
                } else {
                    echo $this->createResponse('error', "Adresse e-mail et/ou mot de passe incorrect", []);
                    exit;
                }
            } else {
                echo $this->createResponse('error', 'Mauvaise requête.', []);
                exit;
            }
        }
    }
}