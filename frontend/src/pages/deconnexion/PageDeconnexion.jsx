/* eslint-disable react/no-unescaped-entities */
import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import Button from "react-bootstrap/esm/Button";
import Card from "react-bootstrap/esm/Card";
import Container from "react-bootstrap/esm/Container";

export default function PageDeconnexion() {
  const navigate = useNavigate();

  const handleGoToAccueil = () => {
    navigate("/");
  };

  useEffect(() => {
    setTimeout(() => {
      navigate("/");
    }, 5000);
  }, [navigate]);

  return (
    <Container className="d-flex justify-content-center align-items-center vh-100 p-0 w-100">
      <Card>
        <Card.Header>Deconnexion</Card.Header>
        <Card.Body className="d-flex justify-content-center align-items-center">
          Vous avez été déconnecté.
          <br />
          Vous allez être redirigé vers l'accueil.
        </Card.Body>
        <Card.Footer>
          <Button
            variant="custom-primary"
            onClick={handleGoToAccueil}
            id="btn-back-to-home-after-logout"
          >
            Retourner à l'accueil
          </Button>
        </Card.Footer>
      </Card>
    </Container>
  );
}
