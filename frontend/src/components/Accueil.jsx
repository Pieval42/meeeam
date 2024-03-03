import { useState } from "react";
import banniere from '/src/assets/images/banniere.svg'

import '/src/assets/style/Accueil.css'

import Button from "react-bootstrap/Button"
import Modal from "react-bootstrap/Modal"
import Form from "react-bootstrap/Form"

function Accueil() {

    const [showConnexion, setShowConnexion] = useState(false);

    const handleCloseConnexion = () => setShowConnexion(false);
    const handleShowConnexion = () => setShowConnexion(true);

    return (
      <>
        <Modal show={showConnexion} onHide={handleCloseConnexion}>
            <Modal.Header closeButton>
                <Modal.Title>Connexion</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <Form>
                    <Form.Group className="mb-3" controlId="formBasicEmail">
                        <Form.Label>Adresse e-mail: </Form.Label>
                        <Form.Control type="email" placeholder="Votre e-mail" />
                        <Form.Text className="text-muted">
                            E-mail utilisé lors de l&apos;inscription
                        </Form.Text>
                    </Form.Group>

                    <Form.Group className="mb-3" controlId="formBasicPassword">
                        <Form.Label>Mot de passe: </Form.Label>
                        <Form.Control type="password" placeholder="Votre mot de passe" />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicCheckbox">
                        <Form.Check type="checkbox" label="Rester connecté" />
                    </Form.Group>
                    <Button variant="secondary" onClick={handleCloseConnexion}>
                        Annuler
                    </Button>
                    <Button variant="primary" type="submit">
                        Se connecter
                    </Button>
                </Form>
            </Modal.Body>
        </Modal>

        <div className="accueil">
          
          <img src={banniere} className="logo" alt="Banniere Meeeam" />
          <hr></hr>
          <h1>Le réseau social des acteurs du monde de la musique.</h1>
          <h2>Lieu d&apos;échange et de rencontre pour les musiciens, producteurs, programmateurs et tous ceux qui font vivre le monde de la musique.</h2>
          <div className="card">
            <p>
              <strong>Bienvenue</strong><br></br>
              Veuillez vous connecter ou vous inscrire pour continuer.
            </p>
            <Button variant="primary" onClick={handleShowConnexion}>
              Connexion
            </Button>
            <Button>
              Inscription
            </Button>
            
          </div>
        </div>
      </>
    )
  }
  
  export default Accueil
  