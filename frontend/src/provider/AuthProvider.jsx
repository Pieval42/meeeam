import { useEffect, useMemo, useState } from "react";
import PropTypes from "prop-types";
import { authContext } from "../contexts/contexts";
import { useAuth } from "../hooks/useAuth";
import { decodeToken } from "../utils/decodeToken";

export default function AuthProvider({ children }) {
  const [infosUtilisateurs, setInfosUtilisateurs] = useState(undefined);
  const [email, setEmail] = useState("");
  const [motDePasse, setMotDePasse] = useState("");
  const [status, setStatus] = useState("inconnu");
  const [token, setToken] = useState({});

  const contextValue = useMemo(
    () => ({
      infosUtilisateurs,
      setInfosUtilisateurs,
      email,
      setEmail,
      motDePasse,
      setMotDePasse,
      status,
      setStatus,
      token,
      setToken,
    }),
    [infosUtilisateurs, email, motDePasse, status, token],
  );

  const auth = useAuth();
  const tokenPayload = decodeToken();

  useEffect(() => {
    setToken(tokenPayload ? JSON.parse(tokenPayload) : null);
  }, [tokenPayload, infosUtilisateurs]);

  useEffect(() => {
    setStatus(auth.status);
  }, [auth, token]);

  // Provide the authentication context to the children components
  return (
    <authContext.Provider value={contextValue}>{children}</authContext.Provider>
  );
}

AuthProvider.propTypes = {
  children: PropTypes.object.isRequired,
};
