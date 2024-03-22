/* eslint-disable react/no-unescaped-entities */
import PropTypes from "prop-types";

import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Button from "react-bootstrap/Button";

import Modal from "react-bootstrap/Modal";
import Form from "react-bootstrap/Form";

function ModalConnexion({
  showConnexion,
  handleCloseConnexion,
  handleShowInscription,
}) {
  function goToInscription() {
    handleShowInscription();
    handleCloseConnexion();
  }
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
            <Row className="justify-content-between">
              <Col xs="auto">
                <Button
                  variant="custom-secondary"
                  onClick={handleCloseConnexion}
                >
                  Annuler
                </Button>
              </Col>
              <Col xs="auto">
                <Button variant="custom-primary" type="submit">
                  Se connecter
                </Button>
              </Col>
            </Row>
          </Form>
        </Modal.Body>
        <Modal.Footer>
          <span className="mr-4">Pas encore de compte?</span>
          <Button
            variant="custom-secondary"
            className="ml-4"
            onClick={() => goToInscription()}
          >
            S'inscrire
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  );
}

ModalConnexion.propTypes = {
  handleCloseConnexion: PropTypes.func.isRequired,
  handleShowInscription: PropTypes.func.isRequired,
  showConnexion: PropTypes.bool.isRequired,
};

export default ModalConnexion;
