import { useState, useEffect, useRef } from "react";
import PropTypes from "prop-types";

import Col from "react-bootstrap/esm/Col";
import Card from "react-bootstrap/esm/Card";

import EnvoiMessage from "./EnvoiMessage";
import MessagesConversation from "./MessagesConversation";


export default function Conversation({ correspondant, id_utilisateur }) {
  
  const scroll = useRef(null);
  const [listeMessages, setListeMessages] = useState([]);

  useEffect(() => {
    scroll.current.scrollIntoView({ behavior: "auto" });
  }, [scroll, listeMessages])

  

  return (
    <Col xs={9} className="h-100">
        <Card className="h-100 mb-3">
          <Card.Header>Conversation avec {correspondant[0]}</Card.Header>
          <Card.Body className="body-conversation">
            <MessagesConversation
                id_utilisateur={id_utilisateur}
                correspondant={correspondant}
                listeMessages={listeMessages}
                setListeMessages={setListeMessages}
            />
            <div ref={scroll}></div>
          </Card.Body>
          <Card.Footer>
            <EnvoiMessage
                correspondant={correspondant}
                id_utilisateur={id_utilisateur}
            />
          </Card.Footer>
        </Card>
    </Col>
  );
}

Conversation.propTypes = {
  correspondant: PropTypes.array.isRequired,
  id_utilisateur: PropTypes.number.isRequired,
};
