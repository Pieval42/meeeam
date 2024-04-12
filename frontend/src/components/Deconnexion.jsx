/* eslint-disable react/no-unescaped-entities */
// import axios from 'axios';
import { useEffect } from 'react';
import { useAuth } from '../hooks/useAuth';
// import { authContext } from '../contexts/contexts';
import { useNavigate } from "react-router-dom";

export default function Deconnexion() {

  const context = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    localStorage.removeItem("Bearer");
    setTimeout(navigate("/"),5000);
    // context.setToken("")
  }, [context, navigate])

  return (
    <div>
      Vous avez été déconnecté, vous allez être redirigés vers l'accueil
    </div>
  )

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
