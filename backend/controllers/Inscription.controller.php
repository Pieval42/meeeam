<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . 'models/PageProfilManager.class.php';
require_once __DIR__ . "/../" . 'models/UtilisateurManager.class.php';
require_once __DIR__ . "/../" . 'models/RequeteManager.class.php';
require_once __DIR__ . "/../" . 'models/VilleManager.class.php';
require_once __DIR__ . "/../" . 'models/SiteWebManager.class.php';

class InscriptionController extends BaseController
{
    private $pageProfilManager;
    private $utilisateurManager;
    private $requeteManager;
    private $villeManager;
    private $siteWebManager;

    public function __construct()
    {
        $this->pageProfilManager = new PageProfilManager;
        $this->utilisateurManager = new UtilisateurManager;
        $this->requeteManager = new RequeteManager;
        $this->villeManager = new VilleManager;
        $this->siteWebManager = new SiteWebManager;
    }

    public function inscription()
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

                $fields = ['pseudo', 'email', 'password', 'prenom', 'nom', 'date_de_naissance', 'id_genre', 'code_postal', 'nom_ville', 'id_pays', 'site_web'];
                $requiredFields = ['pseudo', 'email', 'password', 'prenom', 'nom', 'date_de_naissance'];

                foreach ($fields as $field) {
                    ${$field} = isset($data[$field]) ? $data[$field] : '';
                    if (!$this->validateInput(${$field})) {
                        echo $this->createResponse('error', 'Informations incorrectes.');
                        exit;
                    }
                }

                foreach ($requiredFields as $field) {
                    if (empty($field)) {
                        echo $this->createResponse('error', 'Champs requis manquants.');
                        exit;
                    }
                }

                $regexp = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])(?=.{12,})/';
                if (!preg_match($regexp, $password)) {
                    echo $this->createResponse('error', 'Mot de passe trop faible. Votre mot de passe doit contenir au moins 12 caractères, dont au moins une minuscule, une majuscule, un chiffre et un caractère spécial.');
                    exit;
                }

                $encrypted_password = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );
              
                $this->pageProfilManager = new PageProfilManager;
                $this->requeteManager = new RequeteManager;
                $this->utilisateurManager = new UtilisateurManager;
                $this->villeManager = new VilleManager;
                $this->siteWebManager = new SiteWebManager;
                
                if ($nom_ville && $code_postal && $id_pays) {
                    $ville = $this->villeManager->getVille($nom_ville, $code_postal);
                    if ($ville->getIdVille()) {
                        $id_ville = $ville->getIdVille();
                    } else {
                        $ville = $this->villeManager->creerVille($nom_ville, $code_postal, $id_pays);
                        $id_ville = $ville->getIdVille();
                    }
                } else if ($nom_ville && !$code_postal && !$id_pays) {
                    echo $this->createResponse('error', 'Code postal et pays de la ville manquant.');
                    exit;
                } else if (!$nom_ville && $code_postal && !$id_pays) {
                    echo $this->createResponse('error', 'Nom et pays de la ville manquant.');
                    exit;
                } else if (!$nom_ville && !$code_postal && $id_pays) {
                    echo $this->createResponse('error', 'Nom et code postal de la ville manquant.');
                    exit;
                } else if ($nom_ville && $code_postal && !$id_pays) {
                    echo $this->createResponse('error', 'Pays de la ville manquant.');
                    exit;
                } else if (!$nom_ville && $code_postal && $id_pays) {
                    echo $this->createResponse('error', 'Nom de la ville manquant.');
                    exit;
                } else if ($nom_ville && !$code_postal && $id_pays) {
                    echo $this->createResponse('error', 'Code postal de la ville manquant.');
                    exit;
                }

                if ($adresse_web) {
                    $site_web = $this->siteWebManager->getSiteWeb($adresse_web);
                    if ($site_web) {
                        $adresse_site_web = $adresse_web;
                    } else {
                        $site_web = $this->siteWebManager->creerSiteWeb($adresse_web);
                        $adresse_site_web = $adresse_web;
                    }
                }
                
                $utilisateur = $this->utilisateurManager->creerUtilisateur($pseudo, $nom, $prenom, $date_de_naissance, $email, $encrypted_password, $id_genre, $id_ville);
                $id_utilisateur = $utilisateur->getIdUtilisateur();
                $this->requeteManager->creerRequete($id_utilisateur, $_SERVER['REMOTE_ADDR'], $encrypted_password, $email, "inscription");

                echo $this->createResponse(
                    'success',
                    "Votre compte a été crée avec succès! Vous allez être redirigé vers l'accueil.",
                    [
                        'pseudo' => $pseudo,
                        'password' => $encrypted_password,
                        'email' => $email,
                        'id_page_profil' => $this->pageProfilManager->getPageProfilByIdUtilisateur($id_utilisateur)
                    ]
                );

            } else {
                echo $this->createResponse('error', 'Mauvaise requête.', []);
                exit;
            }
        }
    }
}
