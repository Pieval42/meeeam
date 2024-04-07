import { useState, useEffect } from "react";
import axios from "axios";

import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/esm/Container";
import Col from "react-bootstrap/esm/Col";
import Row from "react-bootstrap/esm/Row";
import ListGroup from "react-bootstrap/esm/ListGroup";
import Button from "react-bootstrap/esm/Button";

import "/src/style/css/Messages.css";
import Conversation from "./Conversation";
import EnvoiMessage from "./EnvoiMessage";

export default function Messages() {
  const [error, setError] = useState("");
  const [listeCorrespondants, setListeCorrespondants] = useState([]);
  const [correspondant, setCorrespondant] = useState([]);
  const [nouvelleConversation, setNouvelleConversation] = useState(false);


  const userData = JSON.parse(sessionStorage.getItem("userData"));
  const id_utilisateur = userData?.id_utilisateur;
  const pseudo_utilisateur = userData?.pseudo_utilisateur;

  useEffect(() => {
    let ignore = false;

    axios
      .get(
        "http://localhost:42600/backend/index.php/messages?id_utilisateur=" +
          id_utilisateur,
      )
      .then((response) => {
        if (!ignore) {
          console.log(response);
          if (response.data.status === "success") {
            let listeCorr = [];
            response.data.data.forEach((row) => {
              row.id_expediteur !== id_utilisateur &&
                listeCorr.push([row.pseudo_expediteur, row.id_expediteur]);
              row.id_destinataire !== id_utilisateur &&
                listeCorr.push([row.pseudo_destinataire, row.id_destinataire]);
            });
            let temp = {};
            listeCorr = listeCorr.filter((corr) => {
              return temp[corr[0]] ? 0 : (temp[corr[0]] = 1);
            });
            setListeCorrespondants(listeCorr);
          } else {
            setError(response.data.message);
          }
        }
      })
      .catch((error) => {
        console.error(error);
      });

    return () => {
      ignore = true;
    };
  }, [id_utilisateur, pseudo_utilisateur]);

  function handleShowConversation(id_correspondant, pseudo_correspondant) {
    setCorrespondant([pseudo_correspondant, id_correspondant]);
  }

  const handleNouvelleConversation = () => {
    setNouvelleConversation(true);
  } 

  return (
    <>
      <div>{error}</div>
      <Container className="conversation mt-3">
        <Row className="h-100">
          <Col xs={3}>
            <Card className="h-100 mb-3">
              <Card.Header>Conversations</Card.Header>
              <Card.Body>
                <Button
                  onClick={handleNouvelleConversation}
                  className="btn-custom-primary mb-3 w-100"
                >
                  Nouvelle conversation
                </Button>
                <ListGroup>
                  {listeCorrespondants.length > 0 &&
                    listeCorrespondants.map((cor) =>
                      cor[0] === correspondant[0] ? (
                        <ListGroup.Item
                          key={cor[1]}
                          className="correspondants selected"
                          onClick={() => handleShowConversation(cor[1], cor[0])}
                        >
                          {cor[0]}
                        </ListGroup.Item>
                      ) : (
                        <ListGroup.Item
                          key={cor[1]}
                          className="correspondants"
                          onClick={() => handleShowConversation(cor[1], cor[0])}
                        >
                          {cor[0]}
                        </ListGroup.Item>
                      ),
                    )}
                </ListGroup>
              </Card.Body>
            </Card>
          </Col>
          {correspondant.length > 0 && (
            <Conversation
              correspondant={correspondant}
              id_utilisateur={id_utilisateur}
            />
          )}
          {nouvelleConversation && (
            <Col xs={9} className="h-100">
              <Card className="h-100 mb-3">
                <Card.Header>
                  Conversation avec{" "}
                  
                  </Card.Header>
                <Card.Body className="body-conversation"></Card.Body>
                <Card.Footer>
                  {correspondant.length > 0 && (
                    <EnvoiMessage
                      correspondant={correspondant}
                      id_utilisateur={id_utilisateur}
                    />
                  )}
                </Card.Footer>
              </Card>
            </Col>
          )}
        </Row>
      </Container>
    </>
  );
}
