import PropTypes from "prop-types";
import { Link } from "react-router-dom";

import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import Dropdown from "react-bootstrap/Dropdown";
import NavItem from "react-bootstrap/NavItem";
import NavLink from "react-bootstrap/NavLink";
import Row from "react-bootstrap/esm/Row";
import Col from "react-bootstrap/esm/Col";
//import NavDropdown from "react-bootstrap/NavDropdown";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";

import "/src/style/css/Header.css";
import Button from "react-bootstrap/esm/Button";

export default function Header({ searchItem, handleInputChange, pseudo }) {
  return (
    <>
      <Container fluid className="header w-100 m-0 p-0">
        <Navbar expand="lg" className="bg-body-tertiary w-100" sticky="top">
          <Container fluid className="justify-content-center">
            <Row className="w-100">
              <Col
                xs={2}
                sm={4}
                lg={2}
                xl={4}
                className="d-flex justify-content-start"
              >
                <Navbar.Brand href="../profil/">
                  <img
                    alt="Logo Meeeam"
                    src="/images/logo.svg"
                    width="30"
                    height="30"
                    className="d-inline-block align-top"
                  />
                </Navbar.Brand>
              </Col>
              <Col
                xs={8}
                sm={4}
                lg={4}
                xl={4}
                className="d-flex justify-content-center"
              >
                <Form
                  method="GET"
                  action="http://localhost:42600/backend/index.php/listeUtilisateurs"
                >
                  <InputGroup>
                    <Form.Control
                      id="search-bar"
                      type="text"
                      value={searchItem}
                      onChange={handleInputChange}
                      placeholder="Rechercher..."
                    />
                    <Button type="submit" variant="custom-secondary">
                      <FontAwesomeIcon icon={faMagnifyingGlass} />
                    </Button>
                  </InputGroup>
                </Form>
              </Col>
              <Col
                xs={2}
                sm={4}
                lg={6}
                xl={4}
                className="d-flex justify-content-end flex-column"
              >
                <Row>
                  <Col xs={12} className="d-flex justify-content-end">
                    <Navbar.Toggle aria-controls="basic-navbar-nav" />
                  </Col>
                </Row>
                <Row>
                  <Col xs={12}></Col>
                </Row>
                <Navbar.Collapse
                  id="basic-navbar-nav"
                  className="justify-content-end"
                >
                  <Nav>
                    <Link to={"pages/"} className="nav-link">
                      Pages
                    </Link>
                    <Link to={"amis/"} className="nav-link">
                      Amis
                    </Link>
                    <Link to={"messages/"} className="nav-link">
                      Messages
                    </Link>

                    <Dropdown as={NavItem} align={{ lg: 'end' }}>
                      <Dropdown.Toggle as={NavLink} className="text-truncate">{pseudo}</Dropdown.Toggle>
                      <Dropdown.Menu id="dropdown-pseudo">
                        <Dropdown.Item
                          href="../profil/"
                          className="nav-link text-center"
                        >
                          Profil
                        </Dropdown.Item>
                        <Dropdown.Item
                          href="../parametres/"
                          className="nav-link text-center"
                        >
                          Paramètres
                        </Dropdown.Item>
                        <Dropdown.Item
                          href="../deconnexion/"
                          className="nav-link text-center"
                        >
                          Déconnexion
                        </Dropdown.Item>
                      </Dropdown.Menu>
                    </Dropdown>
                  </Nav>
                </Navbar.Collapse>
              </Col>
            </Row>
          </Container>
        </Navbar>
      </Container>
    </>
  );
}

Header.propTypes = {
  handleInputChange: PropTypes.func.isRequired,
  searchItem: PropTypes.string,
  pseudo: PropTypes.string,
};
