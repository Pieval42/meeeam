/* eslint-disable react/no-unescaped-entities */
import { useEffect } from "react";
import Button from "react-bootstrap/esm/Button";
import { useNavigate } from "react-router-dom";

export default function PageDeconnexion() {
  const navigate = useNavigate();

  const handleGoToAccueil = () => {
    navigate("/");
  };

  useEffect(() => {
    setTimeout(() => {navigate("/")}, 5000);
  }, [navigate]);

  return (
    <div>
      Vous avez été déconnecté, vous allez être redirigé vers l'accueil.
      <div>
        <Button variant="custom-primary" onClick={handleGoToAccueil}>
          Retourner à l'accueil
        </Button>
      </div>
    </div>
  );
}
