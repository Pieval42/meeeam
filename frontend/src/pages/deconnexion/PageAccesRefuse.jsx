/* eslint-disable react/no-unescaped-entities */
import { useEffect } from "react";
import Button from "react-bootstrap/esm/Button";
import Container from "react-bootstrap/esm/Container";
import Card from "react-bootstrap/esm/Card";
import { useNavigate } from "react-router-dom";

export default function PageAccesRefuse() {
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
        <Card.Header>Accès refusé.</Card.Header>
        <Card.Body className="d-flex justify-content-center align-items-center">
          Vous n'avez pas l'autorisation de voir cette page, veuillez vous
          connecter.
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
