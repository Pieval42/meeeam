import { RouterProvider, createBrowserRouter } from "react-router-dom";
import { ProtectedRoute } from "./ProtectedRoute";

import Accueil from "../pages/Accueil";
import Profil from "../pages/Profil";
import Pages from "../pages/Pages";
import Amis from "../pages/Amis";
import Messages from "../pages/Messages";
import Parametres from "../pages/Parametres";
import Deconnexion from "../components/Deconnexion";
import { useContext, useEffect } from "react";
import { authContext } from "../contexts/contexts";
import { useAuth } from "../hooks/useAuth";

const Routes = () => {
  const context = useContext(authContext);

  const auth = useAuth(context.infosUtilisateurs);
  
  useEffect(() => {
        context.setStatus(auth);
  }, [auth, context])
  
    // // Define public routes accessible to all users
    // const routesForPublic = [
    //   {
    //     path: "/",
    //     element: <Accueil></Accueil>,
    //   },
    // ];
  
    // Define routes accessible only to authenticated users
    const routesForAuthenticatedOnly = [
      {
        path: "/",
        element: (
          <ProtectedRoute>
          </ProtectedRoute>
        ),
        children: [
          {
            path: "profil/",
            element: <Profil />,
          },
          {
            path: "pages/",
            element: <Pages />,
          },
          {
            path: "amis/",
            element: <Amis />,
          },
          {
            path: "messages/",
            element: <Messages />,
          },
          {
            path: "parametres/",
            element: <Parametres />,
          },
          {
            path: "deconnexion/",
            element: <Deconnexion />,
          },
        ],
      },
    ];
  
    // Define routes accessible only to non-authenticated users
    const routesForNotAuthenticatedOnly = [
      {
        path: "/",
        element: <Accueil />,
      },
    ];
  
    // Combine and conditionally include routes based on authentication status
    const router = createBrowserRouter([
      ...(context.status === "connecte" ? routesForAuthenticatedOnly : routesForNotAuthenticatedOnly),
    ]);
  
    // Provide the router configuration using RouterProvider
    return <RouterProvider router={router} />;
  };
  
  export default Routes;