/* eslint-disable react/no-unescaped-entities */
import { useState } from "react";
import PropTypes from "prop-types";
import axios from "axios";

import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";

export default function Inscription({
  showInscription,
  handleHideInscription,
  handleShowConnexion,
}) {
  const [pseudo, setPseudo] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [prenom, setPrenom] = useState("");
  const [nom, setNom] = useState("");
  const [dateNaissance, setDateNaissance] = useState("");
  const [genre, setGenre] = useState("");
  const [ville, setVille] = useState("");
  const [siteWeb, setSiteWeb] = useState("");
  const [apiResponse, setApiResponse] = useState("");
  const [error, setError] = useState("");
  // const [showPassword, setShowPassword] = useState(false);

  const handlePseudoChange = (event) => {
    setPseudo(event.target.value);
  };
  
  const handleEmailChange = (event) => {
    setEmail(event.target.value);
  };
  
  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };
  
  const handlePrenomChange = (event) => {
    setPrenom(event.target.value);
  };
  
  const handleNomChange = (event) => {
    setNom(event.target.value);
  };
  
  const handleDateNaissanceChange = (event) => {
    setDateNaissance(event.target.value);
  };
  
  const handleGenreChange = (event) => {
    setGenre(event.target.value);
  };
  
  const handleVilleChange = (event) => {
    setVille(event.target.value);
  };
  
  const handleSiteWebChange = (event) => {
    setSiteWeb(event.target.value);
  };

  // const handleShowPassword = () => {
  //   setShowPassword(!showPassword);
  // };

  const handleSubmit = (event) => {
    event.preventDefault();

    axios
      .post("http://localhost:42600/backend/index.php/inscription", {
        pseudo: pseudo,
        email: email,
        password: password,
        prenom: prenom,
        nom: nom,
        date_de_naissance: dateNaissance,
        genre: genre,
        ville: ville,
        site_web: siteWeb,
      })
      .then((response) => {
        if (response.data.status === "success") {
          console.log(response);
          setApiResponse(response.data.message);
        } else {
          setError(response.data.message);
        }
      })
      .catch((error) => {
        console.error(error);
        setApiResponse(error.response.data.message);
      });
      window.location.href = "/";
  };

  if (showInscription) {
    return (
      <>
        <Card.Body className="row justify-content-center align-items-center">
          <Col xs={12} className="align-items-center">
            <Form onSubmit={handleSubmit}>
              <Row>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formPseudo"
                >
                  <Form.Label>Pseudo*: </Form.Label>
                  <Form.Control
                    value={pseudo}
                    onChange={handlePseudoChange}
                    type="text"
                    placeholder="Votre pseudo"
                    name="pseudo"
                    autoComplete="username"
                    required
                  />
                  <Form.Text className="text-muted">
                    Votre pseudo peut contenir des lettres et chiffres.
                  </Form.Text>
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formBasicEmail"
                >
                  <Form.Label>Adresse e-mail*: </Form.Label>
                  <Form.Control
                    value={email}
                    onChange={handleEmailChange}
                    type="email"
                    placeholder="Votre e-mail"
                    name="email"
                    autoComplete="email"
                    required
                  />
                  <Form.Text className="text-muted">
                    Veuillez utiliser une adresse e-mail valide.
                  </Form.Text>
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formBasicPassword"
                >
                  <Form.Label>Mot de passe*: </Form.Label>
                  <Form.Control
                    value={password}
                    onChange={handlePasswordChange}
                    type="password"
                    placeholder="Votre mot de passe"
                    name="password"
                    required
                  />
                  <Form.Text className="text-muted">
                    Votre mot de passe doit contenir au moins 12 caractères,
                    dont au moins une minuscule, une majuscule, un chiffre et un
                    caractère spécial.
                  </Form.Text>
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formPrenom"
                >
                  <Form.Label>Prénom*: </Form.Label>
                  <Form.Control
                    value={prenom}
                    onChange={handlePrenomChange}
                    type="text"
                    placeholder="Votre prénom"
                    name="prenom"
                    autoComplete="given-name"
                    required
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formNom"
                >
                  <Form.Label>Nom*: </Form.Label>
                  <Form.Control
                    value={nom}
                    onChange={handleNomChange}
                    type="text"
                    placeholder="Votre prénom"
                    name="nom"
                    autoComplete="family-name"
                    required
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formDateNaissance"
                >
                  <Form.Label>Date de naissance*: </Form.Label>
                  <Form.Control
                    value={dateNaissance}
                    onChange={handleDateNaissanceChange}
                    type="date"
                    placeholder="Votre date de naissance"
                    name="dateNaissance"
                    autoComplete="bday"
                    required
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="d-flex flex-column text-center mb-3"
                  controlId="formGenre"
                >
                  <Row className="justify-content-center h-50">
                    <Form.Label as={Col}>Genre: </Form.Label>
                  </Row>
                  <Row className="h-50 align-items-center">
                    <Col>
                      <Form.Check
                        value="Homme"
                        onChange={handleGenreChange}
                        inline
                        type="radio"
                        id="homme"
                        label="Homme"
                        name="genre"
                      />
                      <Form.Check
                        value="Femme"
                        onChange={handleGenreChange}
                        inline
                        type="radio"
                        id="femme"
                        label="Femme"
                        name="genre"
                      />
                      <Form.Check
                        value="Non-binaire"
                        onChange={handleGenreChange}
                        inline
                        type="radio"
                        id="non-binaire"
                        label="Non-binaire"
                        name="genre"
                      />
                    </Col>
                  </Row>
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  lg={4}
                  className="mb-3"
                  controlId="formVille"
                >
                  <Form.Label>Ville: </Form.Label>
                  <Form.Control
                    value={ville}
                    onChange={handleVilleChange}
                    type="text"
                    placeholder="Votre ville"
                    name="ville"
                    autoComplete="address-level2"
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  lg={4}
                  className="mb-3"
                  controlId="formSiteWeb"
                >
                  <Form.Label>Site Web: </Form.Label>
                  <Form.Control
                    value={siteWeb}
                    onChange={handleSiteWebChange}
                    type="text"
                    placeholder="Votre site web"
                    name="site-web"
                  />
                </Form.Group>
              </Row>

              <Row className="justify-content-end my-3">
                <Col className="d-grid gap-2">
                  <Button variant="custom-primary" size="lg" type="submit">
                    S'inscrire
                  </Button>
                </Col>
                {apiResponse && <Col>{apiResponse}</Col>}
                {error && (
                <Form.Text className="text-warning">
                  {error}
                </Form.Text>
              )}
              </Row>
              <Row className="justify-content-between align-items-center mt-4">
                <Col xs="auto" className="text-start">
                  <Button
                    variant="custom-secondary"
                    onClick={handleHideInscription}
                  >
                    Retour
                  </Button>
                </Col>
                <Col xs="auto">
                  <Row className="justify-content-end align-items-center">
                    <Col xs="auto" className="p-0">
                      <Card.Text>Déjà un compte?</Card.Text>
                    </Col>
                    <Col xs="auto">
                      <Button
                        variant="custom-secondary"
                        onClick={handleShowConnexion}
                      >
                        Se connecter
                      </Button>
                    </Col>
                  </Row>
                </Col>
              </Row>
            </Form>
          </Col>
        </Card.Body>
      </>
    );
  }
}

Inscription.propTypes = {
  handleHideInscription: PropTypes.func.isRequired,
  handleShowConnexion: PropTypes.func.isRequired,
  showInscription: PropTypes.bool.isRequired,
};
