<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . 'models/PageProfilManager.class.php';
require_once __DIR__ . "/../" . 'models/UtilisateurManager.class.php';
require_once __DIR__ . "/../" . 'models/RequeteManager.class.php';


class InscriptionController extends BaseController
{
    private $pageProfilManager;
    private $utilisateurManager;
    private $requeteManager;

    public function __construct()
    {
        $this->pageProfilManager = new PageProfilManager;
        $this->utilisateurManager = new UtilisateurManager;
        $this->requeteManager = new RequeteManager;
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

                $fields = ['pseudo', 'email', 'password', 'prenom', 'nom', 'date_de_naissance', 'genre', 'ville', 'site_web'];
                $requiredFields = ['pseudo', 'email', 'password', 'prenom', 'nom', 'date_de_naissance'];

                foreach ($fields as $field) {
                    ${$field} = isset($data[$field]) ? $data[$field] : '';
                    if (!$this->validateInput(${$field})) {
                        echo $this->createResponse('error', 'You have entered incorrect information.');
                        exit;
                    }
                }

                foreach ($requiredFields as $field) {
                    if (empty($field)) {
                        echo $this->createResponse('error', 'Champs requis manquants.');
                        exit;
                    }
                }

                // $pseudo = isset($data['pseudo']) ? $data['pseudo'] : '';
                // $email = isset($data['email']) ? $data['email'] : '';
                // $password = isset($data['password']) ? $data['password'] : '';
                // $prenom = isset($data['prenom']) ? $data['prenom'] : '';
                // $nom = isset($data['nom']) ? $data['nom'] : '';
                // $date_de_naissance = isset($data['date_de_naissance']) ? $data['date_de_naissance'] : '';
                // $genre = isset($data['genre']) ? $data['genre'] : '';
                // $ville = isset($data['ville']) ? $data['ville'] : '';
                // $site_web = isset($data['site_web']) ? $data['site_web'] : '';

                // if (!$this->validateInput($pseudo) || !$this->validateInput($password) || !$this->validateInput($email) || !$this->validateInput($prenom) || !$this->validateInput($nom) || !$this->validateInput($date_de_naissance) || !$this->validateInput($genre) || !$this->validateInput($ville) || !$this->validateInput($site_web)) {
                //     echo $this->createResponse('error', 'You have entered incorrect information.');
                //     exit;
                // }

                // if (empty($username) or empty($email) or empty($password)) {
                //     echo $this->createResponse('error', 'Champs requis manquants.');
                //     exit;
                // }

                // $pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{12,24}$/';
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

                echo $this->createResponse(
                    'success',
                    'Votre compte a été crée avec succès!',
                    [
                        'pseudo' => $pseudo,
                        'password' => $encrypted_password,
                        'email' => $email,
                        'id_page_profil' => $this->pageProfilManager->getPageProfilByIdUtilisateur($id_utilisateur)
                    ]
                );

                $this->requeteManager = new RequeteManager;
                $this->utilisateurManager = new UtilisateurManager;

                
                $utilisateur = $this->utilisateurManager->creerUtilisateur($pseudo, $nom, $prenom, $date_de_naissance, $email, $encrypted_password, $id_genre, $id_ville);
                $id_utilisateur = $utilisateur->getIdUtilisateur();
                $this->requeteManager->creerRequete($id_utilisateur, $_SERVER['REMOTE_ADDR'], $encrypted_password, $email, "inscription");

            } else {
                echo $this->createResponse('error', 'Mauvaise requête.', []);
                exit;
            }
        }
    }
}
