import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";

import Header from "./Header";

import "/src/style/css/MainTemplate.css";

export default function MainTemplate() {
  const [apiUsers, setApiUsers] = useState([]);
  const [searchItem, setSearchItem] = useState("");
  const [filteredUsers, setFilteredUsers] = useState([]);

  const navigate = useNavigate();
  const userData = JSON.parse(sessionStorage.getItem("userData"));
  const username = userData?.username;

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
        user.prenom_utilisateur.toLowerCase().includes(searchTerm.toLowerCase())
        || user.nom_utilisateur.toLowerCase().includes(searchTerm.toLowerCase())
        || user.pseudo_utilisateur.toLowerCase().includes(searchTerm.toLowerCase())
    );
      setFilteredUsers(filteredItems);
    }
  return (
    <>
      <Header
        searchItem={searchItem}
        handleInputChange={handleInputChange}
        username={username}
      />
      {searchItem !== "" && (
        <ul>
          {filteredUsers.map((user) => (
            <li key={user.id_utilisateur}>{user.pseudo_utilisateur} {user.prenom_utilisateur} {user.nom_utilisateur}</li>
          ))}
        </ul>
      )}
    </>
  );
}
