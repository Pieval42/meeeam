<?php
require_once 'BaseController.controller.php';
require_once __DIR__ . "/../" . '/models/RequeteManager.class.php';
require_once __DIR__ . "/../" . '/models/PageProfilManager.class.php';
require_once __DIR__ . "/../" . '/models/UtilisateurManager.class.php';

use Nowakowskir\JWT\Exceptions\InsecureTokenException;
use Nowakowskir\JWT\Exceptions\UndefinedAlgorithmException;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;


class ConnexionController extends BaseController
{
    private $requeteManager;
    private $pageProfilManager;
    private $utilisateurManager;

    public function __construct()
    {
        $this->requeteManager = new RequeteManager;
        $this->pageProfilManager = new PageProfilManager;
        $this->utilisateurManager = new UtilisateurManager;
    }

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

                $this->requeteManager->creerRequete($utilisateur ? $utilisateur->getIdUtilisateur() : null, $_SERVER['REMOTE_ADDR'], $mot_de_passe_hash, $email, "connexion");

                $requete = $this->requeteManager->getRequetesByEmail($email);

                $mot_de_passe_utilisateur = $utilisateur ? $utilisateur->getMotDePasse() : null;

                if (password_verify($mot_de_passe, $mot_de_passe_utilisateur)) {

                    $id_utilisateur = $requete['id_utilisateur_req'];
                    $id_page_profil = $this->pageProfilManager->getPageProfilByIdUtilisateur($id_utilisateur);
                    $pseudo_utilisateur = $utilisateur->getPseudoUtilisateur();

                    $tokenDecoded = new TokenDecoded(['sub' => 'auth', 'exp' => time() + 3600, 'id_utilisateur' => $id_utilisateur, 'id_page_profil' => $id_page_profil, 'pseudo_utilisateur' => $pseudo_utilisateur], ['alg' => 'RS256', 'typ'=> 'JWT']);
                    try {
                        $tokenEncoded = $tokenDecoded->encode(PRIVATE_KEY, JWT::ALGORITHM_RS256);
                    } catch(InsecureTokenException $e) {
                        echo $this->createResponse('error', $e, []);
                        exit;
                    } catch(UndefinedAlgorithmException $e) {
                        echo $this->createResponse('error', $e, []);
                        exit;
                    }

                    $token = $tokenEncoded->toString();

                    echo $this->createResponse('success', 'Connexion réussie.', ['id_utilisateur' => $id_utilisateur, 'id_page_profil' => $id_page_profil, 'pseudo_utilisateur' => $pseudo_utilisateur], $token);
                } else {
                    echo $this->createResponse('error', "Adresse e-mail et/ou mot de passe incorrect", []);
                    exit;
                }
            } else {
                echo $this->createResponse('error', 'Mauvaise requête.', []);
                exit;
            }
        } elseif($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
        }
    }
}
