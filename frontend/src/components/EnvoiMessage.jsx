import {useState} from "react";
import PropTypes from "prop-types";
import axios from "axios";

import Form from "react-bootstrap/esm/Form";
import InputGroup from "react-bootstrap/esm/InputGroup";
import Button from "react-bootstrap/esm/Button";

export default function EnvoiMessage({
  id_utilisateur,
  correspondant,
}) {
  const [error, setError] = useState("");

  const [messageAEnvoyer, setMessageAEnvoyer] = useState("");

  const handleMessageChange = (e) => {
    const msg = e.target.value;
    setMessageAEnvoyer(msg);
  };
  const placeholder = "Écrire à " + correspondant[0];

  

  const submitMessage = async (e) => {
    e.preventDefault();
    axios
      .post("http://localhost:42600/backend/index.php/messages/envoyer", {
        id_expediteur_prive: id_utilisateur,
        contenu_message: messageAEnvoyer,
        id_destinataire_prive: correspondant[1],
      })
      .then((response) => {
        if (response.data.status === "success") {
          console.log(response);
          setMessageAEnvoyer("");
        } else {
          setError(response.data.message);
          console.log(error);
        }
      })
      .catch((error) => {
        console.error(error);
      });
  };

  return (
    <Form onSubmit={(e) => submitMessage(e)}>
      <InputGroup>
        <Form.Control
          as="textarea"
          id="saisieMessage"
          rows={2}
          placeholder={placeholder}
          value={messageAEnvoyer}
          onChange={handleMessageChange}
        />
        <Button className="btn-custom-primary" id="button-addon2" type="submit">
          Envoyer
        </Button>
      </InputGroup>
    </Form>
  );
}

EnvoiMessage.propTypes = {
  correspondant: PropTypes.array.isRequired,
  id_utilisateur: PropTypes.number.isRequired,
  scroll: PropTypes.object,
};
