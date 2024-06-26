/* eslint-disable react/no-unescaped-entities */
import { useContext } from "react";
import PropTypes from "prop-types";
import axiosInstance from "../../config/axiosConfig";

import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Button from "react-bootstrap/Button";

import Modal from "react-bootstrap/Modal";
import Form from "react-bootstrap/Form";
import { authContext } from "../../contexts/contexts";

function ModalConnexion({
  showConnexion,
  handleCloseConnexion,
  handleShowInscription,
  error,
  setError,
}) {
  const context = useContext(authContext);

  const handleEmailChange = (event) => {
    context.setEmail(event.target.value);
  };

  const handlePasswordChange = (event) => {
    context.setMotDePasse(event.target.value);
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    axiosInstance
      .post("/connexion", {
        email: context.email,
        mot_de_passe: context.motDePasse,
      })
      .then((response) => {
        console.log(response);
        if (response.data.status === "success") {
          context.setInfosUtilisateur(response.data.data);
          localStorage.setItem("infos_utilisateur", JSON.stringify(response.data.data));
          localStorage.setItem("meeeam_access_token", response.data.access_token);
          localStorage.setItem("meeeam_refresh_token", response.data.refresh_token);
        } else {
          setError(response.data.message);
        }
      })
      .catch((error) => {
        console.error(error);
      });
  };

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
          <Form onSubmit={handleSubmit}>
            <Form.Group className="mb-3">
              <Form.Label>Adresse e-mail: </Form.Label>
              <Form.Control
                type="email"
                placeholder="Votre e-mail"
                onChange={handleEmailChange}
                id="login-email-input"
              />
              <Form.Text className="text-muted">
                E-mail utilisé lors de l&apos;inscription
              </Form.Text>
            </Form.Group>

            <Form.Group className="mb-3">
              <Form.Label>Mot de passe: </Form.Label>
              <Form.Control
                type="password"
                placeholder="Votre mot de passe"
                onChange={handlePasswordChange}
                id="login-password-input"
              />
            </Form.Group>

            <Row className="justify-content-between">
              <Col xs="auto">
                <Button
                  variant="custom-secondary"
                  onClick={handleCloseConnexion}
                  id="btn-go-back-to-home"
                >
                  Annuler
                </Button>
              </Col>
              <Col xs="auto">
                <Button variant="custom-primary" type="submit" id="btn-submit-login-form">
                  Se connecter
                </Button>
              </Col>
            </Row>
            {error && (
              <Row>
                <Col>
                  <Form.Text className="text-warning">{error}</Form.Text>
                </Col>
              </Row>
            )}
          </Form>
        </Modal.Body>
        <Modal.Footer>
          <span className="mr-4">Pas encore de compte?</span>
          <Button
            variant="custom-secondary"
            className="ml-4"
            onClick={() => goToInscription()}
            id="btn-go-to-signup-from-login-modal"
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
  error: PropTypes.string.isRequired,
  setError: PropTypes.func.isRequired,
};

export default ModalConnexion;
