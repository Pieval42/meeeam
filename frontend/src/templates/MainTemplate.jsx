import { /*useState, */useContext } from "react";
import { Outlet } from "react-router-dom";
import { authContext } from "../contexts/contexts";
import Header from "./Header";
import { isEmpty } from "../utils/checkEmptyObject";
import "../style/css/MainTemplate.css";


// import Container from "react-bootstrap/esm/Container";
// import Col from "react-bootstrap/esm/Col";
// import Row from "react-bootstrap/esm/Row";


export default function MainTemplate() {
  // const [apiUsers, setApiUsers] = useState([]);
  // const [searchItem, setSearchItem] = useState("");
  // const [filteredUsers, setFilteredUsers] = useState([]);

  // const navigate = useNavigate();
  const context = useContext(authContext);
  const infosUtilisateur = context ? context.infosUtilisateur : undefined;
  const pseudo = !isEmpty(infosUtilisateur)
    ? infosUtilisateur.pseudo_utilisateur
    : "...";

  // useEffect(() => {
  //   const status = context.status;
  //   if (status === "connecte") {
  //     navigate("profil/");
  //   }
  // }, [context.status, navigate]);

  // useEffect(() => {
  //   fetch("http://localhost:42600/backend/index.php/listeUtilisateurs", {
  //     method: "GET",
  //     mode: "cors",
  //   })
  //     .then((response) => response.json())
  //     // save the complete list of users to the new state
  //     .then((data) => setApiUsers(data))
  //     // if there's an error we log it to the console
  //     .catch((err) => console.log(err));
  // }, []);

  // const handleInputChange = (e) => {
  //   const searchTerm = e.target.value;
  //   setSearchItem(searchTerm);

  //   const filteredItems = apiUsers.filter((user) => 
  //       user.prenom_utilisateur.toLowerCase().startsWith(searchTerm.toLowerCase())
  //       || user.nom_utilisateur.toLowerCase().startsWith(searchTerm.toLowerCase())
  //       || user.pseudo_utilisateur.toLowerCase().startsWith(searchTerm.toLowerCase())
  //   );
  //     setFilteredUsers(filteredItems);
  //   }
  return (
    <>
      <Header
        // searchItem={searchItem}
        // handleInputChange={handleInputChange}
        pseudo={pseudo}
      />
      {/* {searchItem !== "" && (
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
      )} */}
      <Outlet></Outlet>
    </>
  );
}
