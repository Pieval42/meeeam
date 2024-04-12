import { Navigate, Outlet } from "react-router-dom";
import MainTemplate from "../pages/MainTemplate";
// import { useContext } from "react";
// import { authContext } from "../contexts/contexts";
import { useAuth } from "../hooks/useAuth";

export const ProtectedRoute = () => {

  // const contextValue = useContext(authContext);

  const auth = useAuth();

  // Check if the user is authenticated
  if (auth.status !== "connecte") {
    // If not authenticated, redirect to the login page
    return <Navigate to="/" />;
  } else {
    // If authenticated, render the child routes
    return <MainTemplate><Outlet /></MainTemplate>;
  }

};
