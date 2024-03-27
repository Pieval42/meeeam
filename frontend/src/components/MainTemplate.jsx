import { useState, useEffect } from "react";
import { useNavigate, Outlet } from "react-router-dom";

import Header from "./Header";

import Container from "react-bootstrap/esm/Container";
import Col from "react-bootstrap/esm/Col";
import Row from "react-bootstrap/esm/Row";

import "/src/style/css/MainTemplate.css";

export default function MainTemplate() {
  const [apiUsers, setApiUsers] = useState([]);
  const [searchItem, setSearchItem] = useState("");
  const [filteredUsers, setFilteredUsers] = useState([]);

  const navigate = useNavigate();
  const userData = JSON.parse(sessionStorage.getItem("userData"));
  const pseudo = userData?.pseudo_utilisateur;

  useEffect(() => {
    const loggedIn = sessionStorage.getItem("loggedIn");
    if (!loggedIn) {
      navigate("/");
    }
  }, [navigate]);

  useEffect(() => {
    fetch("http://localhost:42600/backend/index.php/listeUtilisateurs", {
      method: "GET",
      mode: "cors",
    })
      .then((response) => response.json())
      // save the complete list of users to the new state
      .then((data) => setApiUsers(data))
      // if there's an error we log it to the console
      .catch((err) => console.log(err));
  }, []);

  const handleInputChange = (e) => {
    const searchTerm = e.target.value;
    setSearchItem(searchTerm);

    const filteredItems = apiUsers.filter((user) => 
        user.prenom_utilisateur.toLowerCase().startsWith(searchTerm.toLowerCase())
        || user.nom_utilisateur.toLowerCase().startsWith(searchTerm.toLowerCase())
        || user.pseudo_utilisateur.toLowerCase().startsWith(searchTerm.toLowerCase())
    );
      setFilteredUsers(filteredItems);
    }
  return (
    <>
      <Header
        searchItem={searchItem}
        handleInputChange={handleInputChange}
        pseudo={pseudo}
      />
      {searchItem !== "" && (
        <Container>
        <Row>
          <Col>
            {filteredUsers.map((user) => (
              <div key={user.id_utilisateur}>
                <a>
                  {user.pseudo_utilisateur} {user.prenom_utilisateur}{" "}
                  {user.nom_utilisateur}
                </a>
              </div>
            ))}
          </Col>
        </Row>
      </Container>
      )}
      <Outlet></Outlet>
    </>
  );
}
