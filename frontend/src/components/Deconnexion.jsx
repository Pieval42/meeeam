import { useContext, useEffect } from 'react';
import { authContext } from '../contexts/contexts';
import { useNavigate } from "react-router-dom";
import PageDeconnexion from '../pages/PageDeconnexion';
import PageErreurAuthentification from '../pages/PageErreurAuthentification';
import PageAccesRefuse from '../pages/PageAccesRefuse';

export default function Deconnexion() {

  const context = useContext(authContext);
  const navigate = useNavigate();

  useEffect(() => {
    localStorage.removeItem("Bearer");
    const allKeysFromLocalStorage = Object.keys(localStorage);
    const regexp = new RegExp("^conversation_[0-9]{4}$", "i")
    allKeysFromLocalStorage.map((item) => {
      regexp.test(item) && localStorage.removeItem(item)
    })
    context.setStatus("nonConnecte");
    context.setToken("");
    context.setInfosUtilisateurs(null);
  }, [context, navigate])

  if(context.erreurAuthentification) {
    return (
      <PageErreurAuthentification />
    )
  } else if (context.erreurAuthentification === false) {
    return (
      <PageDeconnexion />
    )
  } else {
    return (
      <PageAccesRefuse />
    )
  }
}
