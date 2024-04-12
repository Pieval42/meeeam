import { useEffect, useMemo, useState } from "react";
import PropTypes from "prop-types";
import {authContext} from "../contexts/contexts";
import { useAuth } from "../hooks/useAuth";

export default function AuthProvider({ children }) {

  const [infosUtilisateurs, setInfosUtilisateurs] = useState(undefined);
  const [email, setEmail] = useState("");
  const [motDePasse, setMotDePasse] = useState("");
  const [status, setStatus] = useState("inconnu");
  const [token, setToken] = useState({});

  const contextValue = useMemo(() => ({
    infosUtilisateurs, setInfosUtilisateurs, email, setEmail, motDePasse, setMotDePasse, status, setStatus, token, setToken
  }), [infosUtilisateurs, email, motDePasse, status, token]);

  const auth = useAuth();
  
  useEffect(() => {
    const tokenEncoded = localStorage.getItem("Bearer");
    if(tokenEncoded) {
      const base64Url = tokenEncoded.split('.')[1];
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      const jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
          return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));
  
      setToken(jsonPayload ? JSON.parse(jsonPayload) : null);
    }
  }, [infosUtilisateurs])
  
  useEffect(() => {
    // setToken(JSON.parse(auth.jsonPayload))
    setStatus(auth.status)
  }, [auth, token])
  
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