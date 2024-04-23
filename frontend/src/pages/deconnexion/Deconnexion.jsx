import { useContext, useEffect } from 'react';
import { authContext } from '../../contexts/contexts';
import PageDeconnexion from './PageDeconnexion';
import PageErreurAuthentification from './PageErreurAuthentification';
import PageAccesRefuse from './PageAccesRefuse';

export default function Deconnexion() {

  const context = useContext(authContext);

  useEffect(() => {
    localStorage.removeItem("Bearer");
    const allKeysFromLocalStorage = Object.keys(localStorage);
    const regex = new RegExp("^conversation_[0-9]{4}$", "i")
    allKeysFromLocalStorage.map((item) => {
      regex.test(item) && localStorage.removeItem(item)
    })
    context.setStatus("nonConnecte");
    context.setToken("");
    context.setInfosUtilisateurs(null);
  }, [context])

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
