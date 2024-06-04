/* eslint-disable react/no-unescaped-entities */
import { useState } from "react";
import axiosInstance from "../../config/axiosConfig";
import Bienvenue from "./Bienvenue";
import Inscription from "./Inscription";
import ModalConnexion from "./ModalConnexion";
import Container from "react-bootstrap/Container";
import Card from "react-bootstrap/Card";
import "/src/style/css/PageAccueil.css";
import { Link } from "react-router-dom";

export default function PageAccueil() {
  const [listePays, setListePays] = useState([]);
  const [error, setError] = useState("");

  const [showConnexion, setShowConnexion] = useState(false);
  const handleCloseConnexion = () => {
    setShowConnexion(false);
    setError("");
  };
  const handleShowConnexion = () => setShowConnexion(true);

  const [showInscription, setShowInscription] = useState(false);
  const handleHideInscription = () => setShowInscription(false);
  const handleShowInscription = () => {
    axiosInstance
      .get("/pays")
      .then((response) => {
        console.log(response);
        if (response.data.status === "success") {
          setListePays(response.data.data);
        } else {
          setError(response.data.message);
        }
      })
      .catch((error) => {
        console.error(error);
      });
    setShowInscription(true);
  };

  return (
    <>
      <ModalConnexion
        showConnexion={showConnexion}
        handleCloseConnexion={handleCloseConnexion}
        handleShowInscription={handleShowInscription}
        error={error}
        setError={setError}
      />
      <Container className="accueil p-0 w-100">
        <Card className="h-100 w-100 m-0">
          <Card.Header className="row w-100 m-0 p-4">
            <Card.Img
              src="/images/banniere.svg"
              alt="Banniere Meeeam"
              className="logo h-100 w-100"
              id="logo-banniere-accueil"
            />
          </Card.Header>
          <Bienvenue
            showInscription={showInscription}
            handleShowConnexion={handleShowConnexion}
            handleShowInscription={handleShowInscription}
          />
          <Inscription
            showInscription={showInscription}
            handleHideInscription={handleHideInscription}
            handleShowConnexion={handleShowConnexion}
            listePays={listePays}
            error={error}
          />
          <Card.Footer>
            <Link to={"cgu/"} className="nav-link">
              Conditions Générales d'Utilisation
            </Link>
          </Card.Footer>
        </Card>
      </Container>
    </>
  );
}
