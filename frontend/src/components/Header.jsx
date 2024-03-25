import PropTypes from "prop-types";

import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
//import NavDropdown from "react-bootstrap/NavDropdown";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";

import "/src/style/css/Header.css";
import Button from "react-bootstrap/esm/Button";

export default function Header({ searchItem, handleInputChange, username }) {
  return (
    <Container fluid className="header w-100 m-0 p-0">
      <Navbar expand="lg" className="bg-body-tertiary w-100">
        <Container fluid>
          <Navbar.Brand href="../profil/">
            <img
              alt="Logo Meeeam"
              src="/images/logo.svg"
              width="30"
              height="30"
              className="d-inline-block align-top"
            />
          </Navbar.Brand>
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

          <Navbar.Toggle aria-controls="basic-navbar-nav" />

          <Navbar.Collapse id="basic-navbar-nav">
            <Nav className="me-auto">
              <Nav.Link href="../profil/">Profil</Nav.Link>
              <Nav.Link href="../pages/">Pages</Nav.Link>
              <Nav.Link href="../amis/">Amis</Nav.Link>
              <Nav.Link href="../groupes/">Groupes</Nav.Link>
              <Nav.Link href="../param/">{username}</Nav.Link>
              <Nav.Link href="/deconnexion">Déconnexion</Nav.Link>
            </Nav>
          </Navbar.Collapse>
        </Container>
      </Navbar>
    </Container>
  );
}

Header.propTypes = {
  handleInputChange: PropTypes.func.isRequired,
  searchItem: PropTypes.string,
  username: PropTypes.string,
};
