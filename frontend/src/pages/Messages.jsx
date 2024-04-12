import { useState, useEffect, useContext } from "react";
import axios from "axios";

import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/esm/Container";
import Col from "react-bootstrap/esm/Col";
import Row from "react-bootstrap/esm/Row";
import ListGroup from "react-bootstrap/esm/ListGroup";
import Button from "react-bootstrap/esm/Button";

import "/src/style/css/Messages.css";
import Conversation from "../components/Conversation";
import { authContext } from "../contexts/contexts";

export default function Messages() {
  const [error, setError] = useState("");
  const [listeCorrespondants, setListeCorrespondants] = useState([]);
  const [correspondant, setCorrespondant] = useState([]);
  const [showConversation, setShowConversation] = useState(false);
  const [changementListe, setChangementListe] = useState(0);

  const context = useContext(authContext);
  const infosUtilisateurs = context ? context.token : undefined;
  const id_utilisateur = context ? infosUtilisateurs.id_utilisateur : undefined;
  const pseudo_utilisateur = context ? infosUtilisateurs.pseudo_utilisateur : undefined;

  useEffect(() => {
    let ignore = false;

    axios
      .get(
        "http://localhost:42600/backend/index.php/messages?id_utilisateur=" +
        encodeURIComponent(id_utilisateur),
        {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("Bearer")}`,
          },
        },
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
  }, [id_utilisateur, pseudo_utilisateur, changementListe, context]);

  useEffect(() => {
    correspondant.length > 0 && setShowConversation(true);
  }, [correspondant, setShowConversation])

  function handleShowConversation(id_correspondant, pseudo_correspondant) {
    setCorrespondant([pseudo_correspondant, id_correspondant]);
  }

  const handleNouvelleConversation = () => {
    setCorrespondant([]);
    setShowConversation(true);
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
          {showConversation && (
            <Conversation
              correspondant={correspondant}
              setCorrespondant={setCorrespondant}
              listeCorrespondants={listeCorrespondants}
              setListeCorrespondants={setListeCorrespondants}
              id_utilisateur={id_utilisateur}
              setChangementListe={setChangementListe}
              changementListe={changementListe}
            />
          )}
        </Row>
      </Container>
    </>
  );
}
