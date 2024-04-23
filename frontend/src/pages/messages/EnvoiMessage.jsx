import {useContext, useEffect, useState} from "react";
import PropTypes from "prop-types";
import { authContext } from "../../contexts/contexts";
import { axiosInstance } from "../../config/axiosConfig";

import Form from "react-bootstrap/esm/Form";
import InputGroup from "react-bootstrap/esm/InputGroup";
import Button from "react-bootstrap/esm/Button";
import { decodeHtmlSpecialChars, encodeHtmlSpecialChars } from "../../utils/htmlSpecialChars";

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
  const [buttonDisabled, setButtonDisabled] = useState(true);
  const [inputDisabled, setInputDisabled] = useState(true);

  useEffect(() => {
    if(correspondant[0]) {
      setInputDisabled(false);
      messageAEnvoyer ? setButtonDisabled(false) : setButtonDisabled(true);
    } else {
      setButtonDisabled(true);
      setInputDisabled(true);
      setMessageAEnvoyer("");
    }
  }, [correspondant, messageAEnvoyer])

  // const corresp = correspondant[0] ? correspondant[0] : "...";
  const placeholder = correspondant[0]
    ?
      "Écrire à " + correspondant[0] + " (500 caractères maximum)"
    :
      "Sélectionner un correspondant"
    ;

  const context = useContext(authContext);

  const handleMessageChange = (e) => {
    const msg = encodeHtmlSpecialChars(e.target.value);
    if(msg.length > 500) {
      return;
    }
    setMessageAEnvoyer(decodeHtmlSpecialChars(msg));
  };

  const handleKeyDown = (e) => {
    if(e.key === 'Enter'){
      if(e.shiftKey) {
        return
      } else {
        e.preventDefault();
        correspondant[0] && submitMessage();
      }
    }
  };

  const submitMessage = async (e) => {
    e && e.preventDefault();
    axiosInstance
      .post("/messages/envoyer", {
        id_expediteur_prive: id_utilisateur,
        contenu_message: messageAEnvoyer.trim(),
        id_destinataire_prive: correspondant[1],
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
        if(error.response.status === 498) {
          context.setErreurAuthentification(true);
        } else {
          console.error(error);
        }
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
          onKeyDown={handleKeyDown}
          disabled={inputDisabled}
        />
        <Button className="btn-custom-primary" id="button-addon2" type="submit" disabled={buttonDisabled}>
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
