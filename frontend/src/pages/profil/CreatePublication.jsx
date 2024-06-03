import { useState, useContext } from "react";
import axiosInstance from "../../config/axiosConfig";
import PropTypes from "prop-types";
import { authContext } from "../../contexts/contexts";
import Card from "react-bootstrap/Card";
import Col from "react-bootstrap/esm/Col";
import Row from "react-bootstrap/esm/Row";
import Button from "react-bootstrap/esm/Button";
import Form from "react-bootstrap/Form";
import CloseButton from "react-bootstrap/esm/CloseButton";
import { isEmpty } from "../../utils/checkEmptyObject";
import "/src/style/css/PageProfil.css";

export default function CreatePublication({ setShowCreatePublication }) {
  const [errorMessage, setErrorMessage] = useState("");
  const [contenu, setContenu] = useState("");
  const [selectedImage, setSelectedImage] = useState(null);

  const [apiResponse, setApiResponse] = useState("");

  const context = useContext(authContext);
  const infosUtilisateur = context ? context.infosUtilisateur : undefined;
  const idUtilisateur = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.id_utilisateur
    : undefined;
  const idPageProfil = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.id_page_profil
    : undefined;

  const handleCloseNewPublication = () => {
    setShowCreatePublication(false);
  };

  const handleContenuChange = (event) => {
    setContenu(event.target.value);
  };

  const handleImageChange = (event) => {
    setSelectedImage(event.target.files[0]);
  };

  const handleSubmitPublication = (event) => {
    event.preventDefault();
    setApiResponse("");
    setErrorMessage("");

    const formData = new FormData();
    formData.append("contenu_publication", contenu);
    formData.append("image", selectedImage);
    formData.append("id_utilisateur", idUtilisateur);
    formData.append("id_page_profil", idPageProfil);

    if (contenu) {
      axiosInstance
        .post("/profil/newPublication", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.status === "success") {
            console.log(response);
            setApiResponse(response.data.message);
            setTimeout(() => {
              setApiResponse("");
              window.location.reload();
            }, 3000);
          } else {
            setErrorMessage(response.data.message);
          }
        })
        .catch((error) => {
          let errorMsg = "";
          if (error.response) {
            errorMsg =
              error.response.status +
              error.response.data +
              error.response.headers;
          } else {
            errorMsg = `${error.code} ${error.message}`;
          }
          console.error(errorMsg);
          setErrorMessage(errorMsg);
        });
    } else {
      setErrorMessage("Veuillez écrire quelque chose pour pouvoir publier.");
    }
  };

  return (
    <>
      <Form onSubmit={handleSubmitPublication}>
        <Card className="h-100">
          <Card.Header>
            <Row>
              <Col
                xs={10}
                className="d-flex justify-content-start align-items-center"
              >
                <span className="text-nowrap">Nouvelle publication </span>
              </Col>
              <Col xs={2} className="text-end">
                <CloseButton
                  onClick={handleCloseNewPublication}
                  className="border rounded"
                />
              </Col>
            </Row>
          </Card.Header>
          <Card.Body>
            <Form.Control
              as="textarea"
              rows={6}
              value={contenu}
              onChange={handleContenuChange}
              placeholder="Écrivez quelque chose..."
              name="text-contenu"
              id="new-pub-input-contenu"
              maxLength={1000}
            />
            <Form.Group className="my-3 text-start">
              <Form.Label>Ajouter une image :</Form.Label>
              <Form.Control
                onChange={handleImageChange}
                type="file"
                accept="image/jpeg, image/png"
                id="new-pub-input-image"
              />
            </Form.Group>
          </Card.Body>
          <Card.Footer>
            <Row>
              <Col xs={7} sm={8} md={9} lg={10}>
                {errorMessage && <Col>{errorMessage}</Col>}
                {apiResponse && apiResponse}
              </Col>
              <Col xs={5} sm={4} md={3} lg={2} className="text-end">
                <Button
                  variant="custom-primary"
                  size="lg"
                  type="submit"
                  data-testid="submitPublicationButton"
                  id="btn-submit-publication"
                >
                  Publier
                </Button>
              </Col>
            </Row>
          </Card.Footer>
        </Card>
      </Form>
    </>
  );
}

CreatePublication.propTypes = {
  setShowCreatePublication: PropTypes.func.isRequired,
};
