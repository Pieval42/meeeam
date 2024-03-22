/* eslint-disable react/no-unescaped-entities */
import PropTypes from "prop-types";

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
  if (showInscription) {
    return (
      <>
        <Card.Body className="row justify-content-center align-items-center">
          <Col xs={12} className="align-items-center">
            <Form>
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
                  controlId="formSexe"
                >
                  <Row className="justify-content-center h-50">
                    <Form.Label as={Col}>Sexe: </Form.Label>
                  </Row>
                  <Row className="h-50 align-items-center">
                    <Col>
                      <Form.Check
                        inline
                        type="radio"
                        id="homme"
                        label="Homme"
                        name="sexe"
                      />
                      <Form.Check
                        inline
                        type="radio"
                        id="femme"
                        label="Femme"
                        name="sexe"
                      />
                      <Form.Check
                        inline
                        type="radio"
                        id="non-binaire"
                        label="Non-binaire"
                        name="sexe"
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
