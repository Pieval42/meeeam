/* eslint-disable react/no-unescaped-entities */
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import PropTypes from "prop-types";
import axios from "axios";

import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import Tooltip from "react-bootstrap/Tooltip";
import OverlayTrigger from "react-bootstrap/OverlayTrigger";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCircleQuestion } from "@fortawesome/free-solid-svg-icons";

export default function Inscription({
  showInscription,
  handleHideInscription,
  handleShowConnexion,
  listePays,
  errorPays,
}) {
  const [pseudo, setPseudo] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [password_confirm, setPasswordConfirm] = useState("");
  const [prenom, setPrenom] = useState("");
  const [nom, setNom] = useState("");
  const [dateNaissance, setDateNaissance] = useState("");
  const [id_genre, setGenre] = useState("I");
  const [ville, setVille] = useState("");
  const [code_postal, setCodePostal] = useState("");
  const [id_pays, setIdPays] = useState("");
  const [siteWeb, setSiteWeb] = useState("");
  const [apiResponse, setApiResponse] = useState("");
  const [error, setError] = useState("");

  const navigate = useNavigate();

  const handlePseudoChange = (event) => {
    setPseudo(event.target.value);
  };

  const handleEmailChange = (event) => {
    setEmail(event.target.value);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };

  const handlePasswordConfirmChange = (event) => {
    setPasswordConfirm(event.target.value);
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

  const handleCodePostalChange = (event) => {
    setCodePostal(event.target.value);
  };

  const handleVilleChange = (event) => {
    setVille(event.target.value);
  };

  const handlePaysChange = (event) => {
    setIdPays(event.target.value);
  };

  const handleSiteWebChange = (event) => {
    setSiteWeb(event.target.value);
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    if (password === password_confirm) {
      setError("");
      axios
        .post("http://localhost:42600/backend/index.php/inscription", {
          pseudo: pseudo,
          email: email,
          password: password,
          prenom: prenom,
          nom: nom,
          date_de_naissance: dateNaissance,
          id_genre: id_genre,
          code_postal: code_postal,
          nom_ville: ville,
          id_pays: id_pays,
          site_web: siteWeb,
        })
        .then((response) => {
          if (response.data.status === "success") {
            console.log(response);
            setApiResponse(response.data.message);
            setTimeout(() => {
              setApiResponse("");
              navigate("../profil/");
            }, 7000);
          } else {
            setError(response.data.message);
          }
        })
        .catch((error) => {
          console.error(error);
          setApiResponse(error.response.data.message);
        });
    } else {
      setApiResponse("");
      setError("Les 2 mots de passe ne correspondent pas.");
    }
    // window.location.href = "/";
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
                  xl={3}
                  className="mb-3"
                  controlId="formPseudo"
                >
                  <Form.Label>
                    <OverlayTrigger
                      placement="top"
                      delay={{ show: 250, hide: 400 }}
                      overlay={
                        <Tooltip id="tooltip-pseudo">
                          Votre pseudo peut contenir des lettres et chiffres.
                        </Tooltip>
                      }
                    >
                      <span className="d-inline-block px-2">
                        <FontAwesomeIcon icon={faCircleQuestion} />
                      </span>
                    </OverlayTrigger>
                    Pseudo* :
                  </Form.Label>
                  <Form.Control
                    value={pseudo}
                    onChange={handlePseudoChange}
                    type="text"
                    placeholder="Votre pseudo"
                    name="pseudo"
                    autoComplete="username"
                    required
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={3}
                  className="mb-3"
                  controlId="formPrenom"
                >
                  <Form.Label>Prénom* : </Form.Label>
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
                  xl={3}
                  className="mb-3"
                  controlId="formNom"
                >
                  <Form.Label>Nom* : </Form.Label>
                  <Form.Control
                    value={nom}
                    onChange={handleNomChange}
                    type="text"
                    placeholder="Votre nom"
                    name="nom"
                    autoComplete="family-name"
                    required
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={3}
                  className="mb-3"
                  controlId="formDateNaissance"
                >
                  <Form.Label>Date de naissance* : </Form.Label>
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
                  className="mb-3"
                  controlId="formBasicEmail"
                >
                  <Form.Label>
                    <OverlayTrigger
                      placement="top"
                      delay={{ show: 250, hide: 400 }}
                      overlay={
                        <Tooltip id="tooltip-email">
                          Veuillez utiliser une adresse e-mail valide.
                        </Tooltip>
                      }
                    >
                      <span className="d-inline-block px-2">
                        <FontAwesomeIcon icon={faCircleQuestion} />
                      </span>
                    </OverlayTrigger>
                    Adresse e-mail* :
                  </Form.Label>
                  <Form.Control
                    value={email}
                    onChange={handleEmailChange}
                    type="email"
                    placeholder="Votre e-mail"
                    name="email"
                    autoComplete="email"
                    required
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formBasicPassword"
                >
                  <Form.Label>
                    <OverlayTrigger
                      placement="top"
                      delay={{ show: 250, hide: 400 }}
                      overlay={
                        <Tooltip id="tooltip-mdp">
                          Votre mot de passe doit contenir au moins 12
                          caractères, dont au moins une minuscule, une
                          majuscule, un chiffre et un caractère spécial.
                        </Tooltip>
                      }
                    >
                      <span className="d-inline-block px-2">
                        <FontAwesomeIcon icon={faCircleQuestion} />
                      </span>
                    </OverlayTrigger>
                    Mot de passe* :
                  </Form.Label>
                  <Form.Control
                    value={password}
                    onChange={handlePasswordChange}
                    type="password"
                    placeholder="Votre mot de passe"
                    name="password"
                    required
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formPasswordConfirm"
                >
                  <Form.Label>Confirmer mot de passe* :</Form.Label>
                  <Form.Control
                    value={password_confirm}
                    onChange={handlePasswordConfirmChange}
                    type="password"
                    placeholder="Confirmer mot de passe"
                    name="password_confirm"
                    required
                  />
                </Form.Group>

                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
                  className="mb-3"
                  controlId="formCodePostal"
                >
                  <Form.Label>Code Postal: </Form.Label>
                  <Form.Control
                    value={code_postal}
                    onChange={handleCodePostalChange}
                    type="text"
                    placeholder="Votre code postal"
                    name="code_postal"
                    autoComplete="postal-code"
                  />
                </Form.Group>
                <Form.Group
                  as={Col}
                  xs={12}
                  sm={6}
                  xl={4}
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
                {errorPays && (
                  <Form.Text className="text-warning">{errorPays}</Form.Text>
                )}
                <Form.Group
                  as={Col} xs={12} sm={6} xl={4} controlId="formPays">
                  <Form.Label>Pays: </Form.Label>
                  <Form.Select
                    aria-label="ListePays"
                    onChange={handlePaysChange}
                  >
                    <option>Choisir un pays:</option>
                    {listePays &&
                      listePays.map((pays) => (
                        <option key={pays.id_pays} value={pays.id_pays}>
                          {pays.nom_fr}
                        </option>
                      ))}
                  </Form.Select>
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
                        value="H"
                        onChange={handleGenreChange}
                        inline
                        type="radio"
                        id="homme"
                        label="Homme"
                        name="genre"
                      />
                      <Form.Check
                        value="F"
                        onChange={handleGenreChange}
                        inline
                        type="radio"
                        id="femme"
                        label="Femme"
                        name="genre"
                      />
                      <Form.Check
                        value="N"
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
                  xl={4}
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
                <Col xs={12} className="d-grid gap-2">
                  <Button variant="custom-primary" size="lg" type="submit">
                    S'inscrire
                  </Button>
                </Col>
                {apiResponse && <Col xs={12}>{apiResponse}</Col>}
                {error && (
                  <Col xs={12}>
                    <Form.Text className="text-warning">{error}</Form.Text>
                  </Col>
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
  listePays: PropTypes.array.isRequired,
  errorPays: PropTypes.string,
};
