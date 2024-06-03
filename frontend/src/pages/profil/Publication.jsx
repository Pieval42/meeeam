import PropTypes from "prop-types";

import { convertSqlDateTimeToFr } from "../../utils/dateUtils";

import Row from "react-bootstrap/esm/Row";
import Col from "react-bootstrap/esm/Col";
import Card from "react-bootstrap/esm/Card";
import Image from "react-bootstrap/esm/Image";

export default function Publication({ listePublications }) {
  return (
    <>
      {listePublications.map((publication) => (
        <Card key={publication.id_publication} className="mb-3">
          <Card.Header>
            <Row>
              <Col className="d-flex justify-content-center align-items-center">
                <span className="text-nowrap">
                  {convertSqlDateTimeToFr(publication.date_heure_publication)}
                </span>
              </Col>
            </Row>
          </Card.Header>
          <Card.Body>
            <Row>
              {publication.url_fichier_publication ? (
                <>
                  <Col
                    xs={12}
                    lg={6}
                    className="d-flex align-items-center justify-content-center p-4"
                  >
                    <Image
                      src={publication.url_fichier_publication}
                      rounded
                      fluid
                    />
                  </Col>
                  <Col
                    xs={12}
                    lg={6}
                    className="d-flex align-items-center justify-content-center py-3"
                  >
                    <div className="d-flex align-items-center justify-content-center h-100 w-100 border rounded mx-3">
                      {publication.contenu_publication}
                    </div>
                  </Col>
                </>
              ) : (
                <Col>{publication.contenu_publication}</Col>
              )}
            </Row>
          </Card.Body>
        </Card>
      ))}
    </>
  );
}

Publication.propTypes = {
  listePublications: PropTypes.array.isRequired,
};
