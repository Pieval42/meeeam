import { useState, useEffect } from "react";
import PropTypes from "prop-types";
import axios from "axios";
import Row from "react-bootstrap/esm/Row";
import Col from "react-bootstrap/esm/Col";

export default function MessagesConversation({
  id_utilisateur,
  correspondant,
  listeMessages,
  setListeMessages,
}) {
  const [error, setError] = useState("");
  const messagesCache = localStorage.getItem(
    `conversation_${id_utilisateur}${correspondant[1]}`,
  );
  
  useEffect(() => {
    messagesCache && setListeMessages(JSON.parse(messagesCache)); 
    function updateMessages() {
      axios
        .get(
          "http://localhost:42600/backend/index.php/messages?id_utilisateur=" +
            id_utilisateur +
            "&id_utilisateur_2=" +
            correspondant[1],
        )
        .then((response) => {
          console.log(response);
          if (response.data.status === "success") {
            let messages = response.data.data;
            messages.forEach((msg) => {
              let dhm = msg.date_heure_message.split(/[- :]/);
              msg.date_heure_message = new Date(
                Date.UTC(dhm[0], dhm[1] - 1, dhm[2], dhm[3], dhm[4], dhm[5]),
              ).toLocaleString("fr-FR", { timeZone: "CET" });
            });
            
            if (messagesCache) {
              if (JSON.stringify(messages) === messagesCache) {
                return
              } else {
                setListeMessages(messages);
                localStorage.setItem(
                  `conversation_${id_utilisateur}${correspondant[1]}`,
                  JSON.stringify(messages),
                );
              }
            } else {
              setListeMessages(messages);
              localStorage.setItem(
                `conversation_${id_utilisateur}${correspondant[1]}`,
                JSON.stringify(messages),
              );
            }
          } else {
            setError(response.data.message);
            console.log(error);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    }
        
    const intervalId = setInterval(updateMessages, 1000);
    return () => clearInterval(intervalId);
  }, [id_utilisateur, correspondant, error, setListeMessages, messagesCache]);



  return (
    <>
      {listeMessages.map((message) => (
        <Row key={message.id_message_prive}>
          {message.id_expediteur_prive === id_utilisateur ? (
            <Col
              xs={{ span: 6, offset: 6 }}
              className="bg-danger-subtle bg-gradient rounded py-2 mb-1"
            >
              {message.contenu_message}
              <br></br>
              <small className="date-heure">{message.date_heure_message}</small>
            </Col>
          ) : (
            <Col xs={6} className="bg-warning-subtle bg-gradient rounded py-2 mb-1">
              {message.contenu_message}
              <br></br>
              <small className="date-heure">{message.date_heure_message}</small>
            </Col>
          )}
        </Row>
      ))}
    </>
  );
}

MessagesConversation.propTypes = {
  correspondant: PropTypes.array.isRequired,
  id_utilisateur: PropTypes.number.isRequired,
  listeMessages: PropTypes.array.isRequired,
  setListeMessages: PropTypes.func.isRequired,
};
