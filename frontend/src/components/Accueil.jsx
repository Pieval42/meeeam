import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";


import Container from "react-bootstrap/Container";
import Card from "react-bootstrap/Card";

import "/src/style/css/Accueil.css";
import ModalConnexion from "./ModalConnexion";
import Bienvenue from "./Bienvenue";
import Inscription from "./Inscription";

export default function Accueil() {
  const [listePays, setListePays] = useState([]);
  const [error, setError] = useState("");

  const [showConnexion, setShowConnexion] = useState(false);
  const handleCloseConnexion = () => setShowConnexion(false);
  const handleShowConnexion = () => setShowConnexion(true);

  const [showInscription, setShowInscription] = useState(false);
  const handleHideInscription = () => setShowInscription(false);
  const handleShowInscription = () => {
    axios
      .get("http://localhost:42600/backend/index.php/pays")
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
  }

  const navigate = useNavigate();

  useEffect(() => {
    const loggedIn = sessionStorage.getItem("loggedIn");
    if (loggedIn) {
      navigate("../main/profil/");
    }
  }, [navigate]);

  return (
    <>
      <ModalConnexion
        showConnexion={showConnexion}
        handleCloseConnexion={handleCloseConnexion}
        handleShowInscription={handleShowInscription}
      />
      <Container className="accueil p-0 w-100">
        <Card className="h-100 w-100 m-0">
          <Card.Header className="row w-100 m-0 p-4">
            <Card.Img
              src="/images/banniere.svg"
              alt="Banniere Meeeam"
              className="logo h-100 w-100"
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
        </Card>
      </Container>
    </>
  );
}
