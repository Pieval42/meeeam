import { useState, useEffect, useCallback, useRef, useContext } from "react";
import PropTypes from "prop-types";
import axios from "axios";
import Row from "react-bootstrap/esm/Row";
import Col from "react-bootstrap/esm/Col";
import { authContext } from "../contexts/contexts";
import { useNavigate } from "react-router-dom";

export default function MessagesConversation({
  id_utilisateur,
  correspondant,
  listeMessages,
  setListeMessages,
}) {
  const [errorMessage, setError] = useState("");
  const messagesCache = localStorage.getItem(
    `conversation_${id_utilisateur}${correspondant[1]}`,
  );
  const [firstRender, setFirstRender] = useState(true);

  const context = useContext(authContext);

  const navigate = useNavigate();

  const updateMessages = useCallback(() => {
    axios
      .get(
        "http://localhost:42600/backend/index.php/messages?id_utilisateur=" +
          encodeURIComponent(id_utilisateur) +
          "&id_utilisateur_2=" +
          encodeURIComponent(correspondant[1]),
        {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("Bearer")}`,
          },
        },
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
              return;
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
          console.log(errorMessage);
        }
      })
      .catch((error) => {        
        if(error.response.status === 498) {
          context.setErreurAuthentification(true);
        } else {
          console.error(error);
        }
      });
  }, [context, correspondant, errorMessage, id_utilisateur, messagesCache, setListeMessages]);

  const autoriserActualisation = useRef(false);

  useEffect(() => {
    autoriserActualisation.current = true;
  }, [correspondant]);

  useEffect(() => {
    let ignore = false;
    if (!ignore) {
      (firstRender || autoriserActualisation.current) && updateMessages();
      setFirstRender(false);
      autoriserActualisation.current = false;
    }
    return () => {
      ignore = true;
    };
  }, [firstRender, updateMessages]);

  useEffect(() => {
    if (autoriserActualisation) {
      messagesCache && setListeMessages(JSON.parse(messagesCache));
      const intervalId = setInterval(updateMessages, 1000);
      return () => clearInterval(intervalId);
    }
  }, [messagesCache, setListeMessages, updateMessages]);

  useEffect(() => {
    context.erreurAuthentification === true && navigate("../deconnexion");
  }, [context.erreurAuthentification, navigate])

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
            <Col
              xs={6}
              className="bg-warning-subtle bg-gradient rounded py-2 mb-1"
            >
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
