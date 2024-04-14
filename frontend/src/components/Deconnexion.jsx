import { useContext, useEffect } from 'react';
import { authContext } from '../contexts/contexts';
import { useNavigate } from "react-router-dom";
import PageDeconnexion from '../pages/PageDeconnexion';

export default function Deconnexion() {

  const context = useContext(authContext);
  const navigate = useNavigate();

  useEffect(() => {
    localStorage.removeItem("Bearer");
    context.setStatus("nonConnecte");
    context.setToken("");
    context.setInfosUtilisateurs(null);
  }, [context, navigate])

  return (
    <PageDeconnexion />
  )
}
