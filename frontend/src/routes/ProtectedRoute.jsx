import { Navigate, Outlet } from "react-router-dom";
import MainTemplate from "../pages/MainTemplate";
import { useContext } from "react";
import { authContext } from "../contexts/contexts";

export const ProtectedRoute = () => {

  const contextValue = useContext(authContext);

  // Check if the user is authenticated
  if (contextValue.status !== "connecte") {
    // If not authenticated, redirect to the login page
    return <Navigate to="/" />;
  } else {
    // If authenticated, render the child routes
    return <MainTemplate><Outlet /></MainTemplate>;
  }

};
