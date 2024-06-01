/* eslint-disable react/no-unescaped-entities */
import PropTypes from "prop-types";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";

export default function Bienvenue({
  showInscription,
  handleShowConnexion,
  handleShowInscription,
}) {
  if (!showInscription) {
    return (
      <Card.Body className="row justify-content-center align-items-center">
        <Col xs={12} className="align-items-center">
          <Row className="h-50 align-items-center mb-2">
            <Col>
              <h1>Le réseau social des acteurs du monde de la musique.</h1>
            </Col>
          </Row>
          <Row className="h-50 align-items-center">
            <Col>
              <h2>Lieu d'échanges, de rencontres et de partage.</h2>
            </Col>
          </Row>
        </Col>
        <Col xs={12} sm={10} md={8} lg={6} className="align-items-center">
          <Card className="align-items-center">
            <Card.Body className="row align-items-center">
              <Col>
                <Card.Text className="h-50 mb-4 align-bottom">
                  Veuillez vous connecter ou vous inscrire pour continuer.
                </Card.Text>
                <Row className="justify-content-center h-50">
                  <Col>
                    <Button
                      variant="custom-secondary"
                      onClick={handleShowConnexion}
                    >
                      Connexion
                    </Button>
                  </Col>
                  <Col>
                    <Button
                      variant="custom-primary"
                      onClick={handleShowInscription}
                      data-testid="goToSignUpPageButton"
                    >
                      Inscription
                    </Button>
                  </Col>
                </Row>
              </Col>
            </Card.Body>
          </Card>
        </Col>
      </Card.Body>
    );
  }
}

Bienvenue.propTypes = {
  handleShowConnexion: PropTypes.func.isRequired,
  handleShowInscription: PropTypes.func.isRequired,
  showInscription: PropTypes.bool.isRequired,
};
