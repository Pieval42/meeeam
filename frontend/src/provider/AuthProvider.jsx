import { useEffect, useMemo, useState } from "react";
import PropTypes from "prop-types";
import { authContext } from "../contexts/contexts";
import { useAuth } from "../hooks/useAuth";
import { decodeToken } from "../utils/tokenService";

export default function AuthProvider({ children }) {
  const [infosUtilisateur, setInfosUtilisateur] = useState(undefined);
  const [email, setEmail] = useState("");
  const [motDePasse, setMotDePasse] = useState("");
  const [status, setStatus] = useState("inconnu");
  const [token, setToken] = useState({});
  const [erreurAuthentification, setErreurAuthentification] =
    useState(undefined);
  const [refreshAuth, setRefreshAuth] = useState(false);
  const [compteSupprime, setCompteSupprime] = useState(false);

  const contextValue = useMemo(
    () => ({
      infosUtilisateur,
      setInfosUtilisateur,
      email,
      setEmail,
      motDePasse,
      setMotDePasse,
      status,
      setStatus,
      token,
      setToken,
      erreurAuthentification,
      setErreurAuthentification,
      refreshAuth,
      setRefreshAuth,
      compteSupprime,
      setCompteSupprime,
    }),
    [infosUtilisateur, email, motDePasse, status, token, erreurAuthentification]
  );

  const auth = useAuth();
  const tokenPayload = auth.status === "connecte" ? decodeToken() : null;

  useEffect(() => {
    setInfosUtilisateur(JSON.parse(localStorage.getItem("infos_utilisateur")));
  }, []);

  useEffect(() => {
    setToken(tokenPayload ? JSON.parse(tokenPayload) : null);
  }, [tokenPayload, infosUtilisateur]);

  useEffect(() => {
    setStatus(auth.status);
    auth.status === "connecte" && setErreurAuthentification(false);
  }, [auth, token, erreurAuthentification]);

  // Fournit le contexte d'authentification aux composants enfants
  return (
    <authContext.Provider value={contextValue}>{children}</authContext.Provider>
  );
}

AuthProvider.propTypes = {
  children: PropTypes.object.isRequired,
};
