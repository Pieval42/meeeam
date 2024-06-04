/* eslint-disable react/no-unescaped-entities */
import { useState, useContext } from "react";
import axiosInstance from "../../config/axiosConfig";
import { authContext } from "../../contexts/contexts";
import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/esm/Container";
import Col from "react-bootstrap/esm/Col";
import Row from "react-bootstrap/esm/Row";
import Modal from "react-bootstrap/esm/Modal";
import "/src/style/css/PageProfil.css";
import { isEmpty } from "../../utils/checkEmptyObject";
import { calculateAge } from "../../utils/dateUtils";
import Image from "react-bootstrap/esm/Image";
import { Link, useNavigate } from "react-router-dom";
import Button from "react-bootstrap/esm/Button";

export default function PageParametres() {
  const [showModal, setShowModal] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

  const handleClose = () => setShowModal(false);
  const handleShowModal = () => setShowModal(true);

  const context = useContext(authContext);
  const infosUtilisateur = context ? context.infosUtilisateur : undefined;
  const idUtilisateur = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.id_utilisateur
    : undefined;
  const detailsUtilisateur = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.details_utilisateur
    : undefined;
  const ageUtilisateur = !isEmpty(detailsUtilisateur)
    ? calculateAge(detailsUtilisateur.date_naissance)
    : undefined;

  const navigate = useNavigate();

  const handleConfirmDelete = () => {
    axiosInstance
      .delete(
        "/utilisateur/delete?id_utilisateur=" +
          encodeURIComponent(idUtilisateur)
      )
      .then((response) => {
        if (response.data.status === "success") {
          context.setCompteSupprime(true);
          navigate("/deconnexion/");
        } else {
          setErrorMessage(response.data.message);
        }
      })
      .catch((error) => {
        if (error.response.status === 401) {
          context.setErreurAuthentification(true);
        } else {
          console.error(error);
        }
      });
  };

  return (
    <>
      <Modal
        show={showModal}
        onHide={handleClose}
        backdrop="static"
        keyboard={false}
      >
        <Modal.Header closeButton>
          <Modal.Title>Supprimer compte?</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          Voulez-vous vraiment supprimer votre compte?
          <br />
          Cette action est irréversible.
          <br />
          Vos données seront supprimées définitivement.
        </Modal.Body>
        <Modal.Footer className="d-flex justify-content-start">
          <Row className="w-100">
            <Col className="d-flex justify-content-start">
              <Button className="btn-custom-secondary" onClick={handleClose}>
                Annuler
              </Button>
            </Col>
            <Col className="d-flex justify-content-end">
              <Button
                onClick={handleConfirmDelete}
                className="btn-custom-primary"
              >
                Confirmer
              </Button>
            </Col>
          </Row>
        </Modal.Footer>
      </Modal>
      <div>{errorMessage}</div>
      <Container className="profil-side-card mt-3">
        <Row className="">
          <Col xs={12} lg={3}>
            <Card className="mb-3">
              <Card.Header>A propos</Card.Header>
              <Card.Body>
                {detailsUtilisateur && (
                  <>
                    <Row className="mb-3">
                      <Col xs={6}>
                        <Image
                          id="image-profil"
                          src="/images/user_default.jpg"
                          fluid
                          rounded
                        />
                      </Col>
                      <Col
                        xs={6}
                        className="d-flex align-items-center justify-content-center"
                      >
                        {detailsUtilisateur.prenom_utilisateur}
                        <br />
                        {detailsUtilisateur.nom_utilisateur}
                      </Col>
                    </Row>
                    <Row>
                      <Col className="text-start mb-2">
                        {ageUtilisateur} ans
                      </Col>
                    </Row>

                    {detailsUtilisateur.genre && (
                      <Row>
                        <Col className="text-start mb-2">
                          {detailsUtilisateur.genre}
                        </Col>
                      </Row>
                    )}

                    {detailsUtilisateur.ville && (
                      <Row>
                        <Col className="text-start">
                          {detailsUtilisateur.ville}
                        </Col>
                      </Row>
                    )}

                    {detailsUtilisateur.pays && (
                      <Row>
                        <Col className="text-start mb-2">
                          {detailsUtilisateur.pays}
                        </Col>
                      </Row>
                    )}

                    {detailsUtilisateur.sites_web.length > 0 &&
                      detailsUtilisateur.sites_web.map((site) => (
                        <Row key={site.adresse_site_web_liste}>
                          <Col className="text-start">
                            <Card.Link
                              href={site.adresse_site_web_liste}
                              target="_blank"
                            >
                              {site.adresse_site_web_liste}
                            </Card.Link>
                          </Col>
                        </Row>
                      ))}
                  </>
                )}
              </Card.Body>
              <Card.Footer>
                <Link to={"/cgu/"} className="nav-link">
                  <small>Conditions Générales d'Utilisation</small>
                </Link>
              </Card.Footer>
            </Card>
          </Col>
          <Col xs={12} lg={9}>
            <Card>
              <Card.Header>Paramètres du compte</Card.Header>
              <Card.Body>
                <Row>
                  <Col className="d-flex align-items-center">
                    Supprimer compte utilisateur :
                  </Col>
                  <Col className="d-flex justify-content-end align-items-center">
                    <Button
                      className="btn-custom-primary"
                      onClick={handleShowModal}
                    >
                      Supprimer
                    </Button>
                  </Col>
                </Row>
              </Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
    </>
  );
}
