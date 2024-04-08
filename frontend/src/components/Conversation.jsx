import { useState, useEffect, useRef } from "react";
import PropTypes from "prop-types";
import axios from "axios";

import Row from "react-bootstrap/esm/Row";
import Col from "react-bootstrap/esm/Col";
import Card from "react-bootstrap/esm/Card";

import EnvoiMessage from "./EnvoiMessage";
import MessagesConversation from "./MessagesConversation";
import Form from "react-bootstrap/esm/Form";
import ListGroup from "react-bootstrap/esm/ListGroup";

export default function Conversation({
  correspondant,
  setCorrespondant,
  listeCorrespondants,
  setListeCorrespondants,
  id_utilisateur,
  setChangementListe,
  changementListe,
}) {
  const [error, setError] = useState("");
  const scroll = useRef(null);
  const [listeMessages, setListeMessages] = useState([]);
  const [searchItem, setSearchItem] = useState("");
  const [listeUtilisateurs, setListeUtilisateurs] = useState([]);
  const [nouveauCorrespondant, setNouveauCorrespondant] = useState([]);

  useEffect(() => {
    scroll.current.scrollIntoView({ behavior: "auto" });
  }, [scroll, listeMessages]);

  useEffect(() => {
    nouveauCorrespondant.length > 0 && setCorrespondant(nouveauCorrespondant);
  }, [setCorrespondant, nouveauCorrespondant]);

  const handleInputChange = (e) => {
    const searchTerm = e.target.value;
    setSearchItem(searchTerm);
    if (searchTerm !== ("" && null && undefined)) {
      axios
        .get(
          "http://localhost:42600/backend/index.php/listeUtilisateurs?search=" +
            encodeURIComponent(searchTerm),
        )
        .then((response) => {
          console.log(response);
          if (response.data.status === "success") {
            let listeRecue = JSON.parse(response.data.data);
            // const indexUtilisateurActuel = listeRecue.findIndex((user) => user.id_utilisateur === id_utilisateur);
            // console.log(indexUtilisateurActuel);
            // listeRecue = listeRecue.splice(indexUtilisateurActuel, 1);
            listeRecue = listeRecue.filter((user) => {return user.id_utilisateur !== id_utilisateur});
            setListeUtilisateurs(listeRecue);
          } else {
            setError(response.data.message);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    } else {
      setSearchItem("");
      setListeUtilisateurs([]);
    }
  };

  const handleSelectUtilisateur = (e) => {
    setSearchItem("");
    setListeUtilisateurs([]);
    setNouveauCorrespondant([e.target.getAttribute("pseudo"), parseInt(e.target.getAttribute("id"))]);
  };

  return (
    <Col xs={9} className="h-100">
      <Card className="h-100 mb-3">
        {correspondant.length > 0 ? (
          <Card.Header>Conversation avec {correspondant[0]}</Card.Header>
        ) : (
          <Card.Header>
            <Row>
              <Col className="d-flex justify-content-center align-items-center">
                <span className="text-nowrap">Écrire à : </span>
                <Form.Control
                  id="recherche-utilisateur"
                  type="text"
                  value={searchItem}
                  onChange={handleInputChange}
                  placeholder="Rechercher utilisateur..."
                  className="mx-2"
                />
              </Col>
            </Row>
          </Card.Header>
        )}
        {listeUtilisateurs.length > 0 &&
          searchItem !== ("" && null && undefined) &&
          correspondant.length === 0 && (
            <Card className="liste-utilisateurs">
              {error && { error }}
              <ListGroup>
                {listeUtilisateurs.map((user) => {
                  return (
                    <ListGroup.Item
                      key={user.id_utilisateur}
                      id={user.id_utilisateur}
                      pseudo={user.pseudo_utilisateur}
                      onClick={handleSelectUtilisateur}
                    >
                      {user.pseudo_utilisateur} {user.prenom_utilisateur}{" "}
                      {user.nom_utilisateur}
                    </ListGroup.Item>
                  );
                })}
              </ListGroup>
            </Card>
          )}
        <Card.Body className="body-conversation">
          {correspondant.length > 0 && (
            <MessagesConversation
              id_utilisateur={id_utilisateur}
              correspondant={correspondant}
              listeMessages={listeMessages}
              setListeMessages={setListeMessages}
            />
          )}
          <div ref={scroll}></div>
        </Card.Body>
        <Card.Footer>
          <EnvoiMessage
            correspondant={correspondant}
            id_utilisateur={id_utilisateur}
            listeCorrespondants={listeCorrespondants}
            setListeCorrespondants={setListeCorrespondants}
            setChangementListe={setChangementListe}
            changementListe={changementListe}
          />
        </Card.Footer>
      </Card>
    </Col>
  );
}

Conversation.propTypes = {
  correspondant: PropTypes.array.isRequired,
  setCorrespondant: PropTypes.func.isRequired,
  listeCorrespondants: PropTypes.array.isRequired,
  setListeCorrespondants: PropTypes.func.isRequired,
  id_utilisateur: PropTypes.number.isRequired,
  setChangementListe: PropTypes.func.isRequired,
  changementListe: PropTypes.number.isRequired,
};
