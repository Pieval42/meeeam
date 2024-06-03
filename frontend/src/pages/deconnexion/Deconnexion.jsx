import { useContext, useEffect } from "react";
import { authContext } from "../../contexts/contexts";
import PageDeconnexion from "./PageDeconnexion";
import PageErreurAuthentification from "./PageErreurAuthentification";
import PageAccesRefuse from "./PageAccesRefuse";

export default function Deconnexion() {
  const context = useContext(authContext);

  useEffect(() => {
    localStorage.removeItem("meeeam_access_token");
    localStorage.removeItem("meeeam_refresh_token");
    const allKeysFromLocalStorage = Object.keys(localStorage);
    const regex = new RegExp("^conversation_[0-9]{4,}$", "i");
    allKeysFromLocalStorage.map((item) => {
      regex.test(item) && localStorage.removeItem(item);
    });
    localStorage.removeItem("infos_utilisateur");
    context.setStatus("nonConnecte");
    context.setToken("");
    context.setInfosUtilisateur(null);
  }, [context]);

  if (context.erreurAuthentification) {
    return <PageErreurAuthentification />;
  } else if (context.erreurAuthentification === false) {
    return <PageDeconnexion />;
  } else {
    return <PageAccesRefuse />;
  }
}
