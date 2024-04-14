/* eslint-disable react/no-unescaped-entities */
import Button from "react-bootstrap/esm/Button";
import { useNavigate } from "react-router-dom";

export default function PageDeconnexion() {
  const navigate = useNavigate();

  const handleGoToAccueil = () => {
    navigate("/");
  };
  return (
    <div>
      Vous devez être connecté pour voir cette page
      <div>
        <Button variant="custom-primary" onClick={handleGoToAccueil}>
          Retourner à l'accueil
        </Button>
      </div>
    </div>
  );
}
