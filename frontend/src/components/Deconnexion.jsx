// import axios from 'axios';
// import { useNavigate } from 'react-router-dom';
import { useEffect } from 'react';
import { useAuth } from '../hooks/useAuth';

export default function Deconnexion() {

  const { deconnexion } = useAuth();

  useEffect(() => {
    deconnexion
  }, [deconnexion])

  // const { setToken } = useAuth();
  // const navigate = useNavigate();

  // const handleLogout = () => {
  //   setToken();
  //   navigate("/", { replace: true });
  // };

  // setTimeout(() => {
  //   handleLogout();
  // }, 3 * 1000);
  
  // axios.post('http://localhost:42600/backend/index.php/connexion')
  // .then(() => {
  //   sessionStorage.clear();
  //   navigate("/");
  // })
  // .catch((error) => {
  //    console.error(error);
  // });
}
