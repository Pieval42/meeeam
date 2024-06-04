/* eslint-disable react/no-unescaped-entities */
import { useState, useEffect, useContext } from "react";
import axiosInstance from "../../config/axiosConfig";
import { authContext } from "../../contexts/contexts";
import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/esm/Container";
import Col from "react-bootstrap/esm/Col";
import Row from "react-bootstrap/esm/Row";
import Button from "react-bootstrap/esm/Button";
import "/src/style/css/PageProfil.css";
import Publication from "./Publication";
import CreatePublication from "./CreatePublication";
import { isEmpty } from "../../utils/checkEmptyObject";
import { calculateAge } from "../../utils/dateUtils";
import Image from "react-bootstrap/esm/Image";
import { Link } from "react-router-dom";

export default function PageProfil() {
  const [errorMessage, setErrorMessage] = useState("");
  const [listePublications, setListePublications] = useState([]);
  const [showCreatePublication, setShowCreatePublication] = useState(false);

  const context = useContext(authContext);
  const infosUtilisateur = context ? context.infosUtilisateur : undefined;
  const idUtilisateur = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.id_utilisateur
    : undefined;
  const idPageProfil = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.id_page_profil
    : undefined;
  const detailsUtilisateur = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.details_utilisateur
    : undefined;
  const ageUtilisateur = !isEmpty(detailsUtilisateur)
    ? calculateAge(detailsUtilisateur.date_naissance)
    : undefined;

  useEffect(() => {
    let ignore = false;
    if (idUtilisateur && idPageProfil) {
      axiosInstance
        .get(
          "/profil/getPublications?id_utilisateur=" +
            encodeURIComponent(idUtilisateur) +
            "&id_page_profil=" +
            encodeURIComponent(idPageProfil)
        )
        .then((response) => {
          if (!ignore) {
            console.log("Réponse du serveur : ", response);
            if (response.data.status === "success") {
              console.log("Données des publications : ", response.data.data);
              setListePublications(response.data.data);
            } else {
              setErrorMessage(response.data.message);
            }
          }
        })
        .catch((error) => {
          if (error.response.status === 401) {
            context.setErreurAuthentification(true);
          } else {
            console.error(error);
          }
        });
    }

    return () => {
      ignore = true;
    };
  }, [idUtilisateur, idPageProfil]);

  const handleNouvellePublication = () => {
    setShowCreatePublication(true);
  };

  const handleBackToProfile = () => {
    setShowCreatePublication(false);
  };

  return (
    <>
      <div>{errorMessage}</div>
      <Container className="profil-side-card mt-3">
        <Row className="">
          <Col xs={12} lg={3}>
            <Card className="mb-3">
              <Card.Header>Profil</Card.Header>
              <Card.Body className="">
                {showCreatePublication ? (
                  <Button
                    onClick={handleBackToProfile}
                    className="btn-custom-primary mb-3 w-100"
                  >
                    Retour au profil
                  </Button>
                ) : (
                  <Button
                    onClick={handleNouvellePublication}
                    className="btn-custom-primary mb-3 w-100"
                  >
                    Nouvelle publication
                  </Button>
                )}
                <Card>
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
                </Card>
                <Link to={"cgu/"} className="nav-link mt-3"><small>Conditions Générales d'Utilisation</small></Link>
              </Card.Body>
            </Card>
          </Col>
          <Col xs={12} lg={9}>
            {showCreatePublication ? (
              <CreatePublication
                setShowCreatePublication={setShowCreatePublication}
              />
            ) : listePublications.length > 0 ? (
              <Publication listePublications={listePublications} />
            ) : (
              <Col className="h-100">Aucune publication pour le moment.</Col>
            )}
          </Col>
        </Row>
      </Container>
    </>
  );
}
