import axios from 'axios';
import { useNavigate } from 'react-router-dom';

export default function Deconnexion() {
  const navigate = useNavigate();
  
  axios.post('http://localhost:42600/backend/index.php/connexion')
  .then(() => {
    sessionStorage.clear();
    navigate("/");
  })
  .catch((error) => {
     console.error(error);
  });
}
