/* eslint-disable react/no-unescaped-entities */
import { useState } from "react";
import PropTypes from "prop-types";
import axios from "axios";
// import { Form as FormRouter } from "react-router-dom";

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
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  // const [showPassword, setShowPassword] = useState(false);

  const handleEmailChange = (event) => {
    setEmail(event.target.value);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };

  // const handleShowPassword = () => {
  //   setShowPassword(!showPassword);
  // };

  const handleSubmit = (event) => {
    event.preventDefault();
    axios
      .post("http://localhost:42600/backend/index.php/connexion", {
        email: email,
        mot_de_passe: password,
      })
      .then((response) => {
        console.log(response);
        if (response.data.status === "success") {
          sessionStorage.setItem("loggedIn", true);
          sessionStorage.setItem(
            "userData",
            JSON.stringify(response.data.data),
          );

          window.location.href = "profil/";
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
            <Form.Group className="mb-3" controlId="formBasicEmail">
              <Form.Label>Adresse e-mail: </Form.Label>
              <Form.Control
                type="email"
                placeholder="Votre e-mail"
                onChange={handleEmailChange}
              />
              <Form.Text className="text-muted">
                E-mail utilisé lors de l&apos;inscription
              </Form.Text>
            </Form.Group>

            <Form.Group className="mb-3" controlId="formBasicPassword">
              <Form.Label>Mot de passe: </Form.Label>
              <Form.Control
                type="password"
                placeholder="Votre mot de passe"
                onChange={handlePasswordChange}
              />
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
