import { useEffect, useMemo, useState } from "react";
import PropTypes from "prop-types";
import {authContext} from "../contexts/contexts";
import { useAuth } from "../hooks/useAuth";

export default function AuthProvider({ children }) {

  const [infosUtilisateurs, setInfosUtilisateurs] = useState(undefined);
  const [email, setEmail] = useState("");
  const [motDePasse, setMotDePasse] = useState("");
  const [status, setStatus] = useState("inconnu");

  const contextValue = useMemo(() => ({
    infosUtilisateurs, setInfosUtilisateurs, email, setEmail, motDePasse, setMotDePasse, status, setStatus
  }), [infosUtilisateurs, email, motDePasse, status]);

  const auth = useAuth(contextValue);

  useEffect(() => {
    setStatus(auth)
  }, [auth, contextValue])

  // Provide the authentication context to the children components
  return (
    <authContext.Provider
      value={contextValue}
    >
      {children}
    </authContext.Provider>
  );
}

AuthProvider.propTypes = {
    children: PropTypes.object.isRequired
}