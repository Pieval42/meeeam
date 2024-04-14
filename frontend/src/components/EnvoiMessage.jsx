import {useState} from "react";
import PropTypes from "prop-types";
import axios from "axios";

import Form from "react-bootstrap/esm/Form";
import InputGroup from "react-bootstrap/esm/InputGroup";
import Button from "react-bootstrap/esm/Button";

export default function EnvoiMessage({
  id_utilisateur,
  correspondant,
  listeCorrespondants,
  setListeCorrespondants,
  setChangementListe,
  changementListe,
}) {
  const [error, setError] = useState("");

  const [messageAEnvoyer, setMessageAEnvoyer] = useState("");

  const handleMessageChange = (e) => {
    const msg = e.target.value;
    setMessageAEnvoyer(msg);
  };
  const corresp = correspondant[0] ? correspondant[0] : "..."
  const placeholder = "Écrire à " + corresp;

  const submitMessage = async (e) => {
    e.preventDefault();
    axios
      .post("http://localhost:42600/backend/index.php/messages/envoyer", {
        id_expediteur_prive: id_utilisateur,
        contenu_message: messageAEnvoyer,
        id_destinataire_prive: correspondant[1],
      },
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("Bearer")}`,
        },
      },
    )
      .then((response) => {
        if (response.data.status === "success") {
          console.log(response);
          setMessageAEnvoyer("");
          let listeModifiee = listeCorrespondants;
          let correspondantDansListe = listeCorrespondants.find((c) => c[1] === correspondant[1]) ? true : false;
          !correspondantDansListe && listeModifiee.splice(0, 0, correspondant);
          setListeCorrespondants(listeModifiee);
          setChangementListe(changementListe + 1);
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
  listeCorrespondants: PropTypes.array.isRequired,
  setListeCorrespondants: PropTypes.func.isRequired,
  setChangementListe: PropTypes.func.isRequired,
  changementListe: PropTypes.number.isRequired,
};
