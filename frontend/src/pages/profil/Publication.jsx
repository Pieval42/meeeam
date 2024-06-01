import { useEffect, useState } from "react";
import PropTypes from "prop-types";

import Row from "react-bootstrap/esm/Row";
import Col from "react-bootstrap/esm/Col";
import Card from "react-bootstrap/esm/Card";

export default function Conversation({ listePublications }) {
  const [errorMessage, setErrorMessage] = useState("");

  useEffect(() => {
    errorMessage && setErrorMessage("Erreur");
  }, [])

  return (
    <Col xs={9}>
      {errorMessage && (
        <Col>{errorMessage}</Col>
      )}
      {listePublications.length > 0 ? (
        <Col className="">
          <Card className="h-100 mb-3">
            <Card.Header>
              <Row>
                <Col className="d-flex justify-content-center align-items-center">
                  <span className="text-nowrap">Date Heure </span>
                </Col>
              </Row>
            </Card.Header>
            <Card.Body>
              {listePublications}
            </Card.Body>
          </Card>
        </Col>
      ) : (
        <Col className="h-100">Aucune publication pour le moment.</Col>
      )
    }
    </Col>
  );
}

Conversation.propTypes = {
  listePublications: PropTypes.array.isRequired,
};
