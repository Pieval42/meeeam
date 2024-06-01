import { useState, useEffect, useContext } from "react";
import axiosInstance from "../../config/axiosConfig";
import { authContext } from "../../contexts/contexts";
import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/esm/Container";
import Col from "react-bootstrap/esm/Col";
import Row from "react-bootstrap/esm/Row";
import Button from "react-bootstrap/esm/Button";
import "/src/style/css/PageProfil.css";
import Publication from "./Publication"

export default function PageProfil() {
  const [error, setError] = useState("");
  const [listePublications, setListePublications] = useState([]);

  const context = useContext(authContext);
  const infosUtilisateurs = context ? context.token : undefined;
  const id_utilisateur = context ? infosUtilisateurs.id_utilisateur : undefined;
  
  useEffect(() => {
    let ignore = false;

    axiosInstance
      .get("/profil/get?id_utilisateur=" + encodeURIComponent(id_utilisateur))
      .then((response) => {
        if (!ignore) {
          console.log(response);
          if (response.data.status === "success") {
            console.log(response.data.data);
          } else {
            setError(response.data.message);
          }
        }
      })
      .catch((error) => {
        if (error.response.status === 401) {
          context.setErreurAuthentification(true);
        } else {
          console.error(error);
        }
      });

    return () => {
      ignore = true;
    };
  }, [id_utilisateur, context]);

  const handleNouvellePublication = () => {
    console.log("coucou");
    const pub = ["Publication 1"];
    setListePublications(pub)
  }

  return (
    <>
      <div>{error}</div>
      <Container className="profil-side-card mt-3">
        <Row className="h-100">
          <Col xs={3}>
            <Card className="mb-3 card-correspondants">
              <Card.Header>Profil</Card.Header>
              <Card.Body className="h-100 liste-correspondants">
                <Button
                  onClick={handleNouvellePublication}
                  className="btn-custom-primary mb-3 w-100"
                >
                  Nouvelle publication
                </Button>
                <Card>
                  <Card.Header>
                    A propos
                  </Card.Header>
                  <Card.Body>
                    Coucou
                  </Card.Body>
                </Card>
              </Card.Body>
            </Card>
          </Col>
          <Publication
            listePublications={listePublications}
          />
        </Row>
      </Container>
    </>
  );
}
