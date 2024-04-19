import { RouterProvider, createBrowserRouter } from "react-router-dom";
import { ProtectedRoute } from "./ProtectedRoute";

import Accueil from "../pages/Accueil";
import Profil from "../pages/Profil";
import Pages from "../pages/Pages";
import Amis from "../pages/Amis";
import Messages from "../pages/Messages";
import Parametres from "../pages/Parametres";
import Deconnexion from "../components/Deconnexion";
import { useAuth } from "../hooks/useAuth";
import { useContext, useEffect, useMemo } from "react";
import { authContext } from "../contexts/contexts";

const Routes = () => {
  const auth = useAuth();
  const context = useContext(authContext);

  useEffect(() => {}, [context.status, context.erreurAuthentification]);

  // Define public routes accessible to all users
  const routesForPublic = useMemo(() => {
    return [
      {
        path: "/",
        element: <Accueil></Accueil>,
      },
      {
        path: "pages/",
        element: <Deconnexion />,
      },
      {
        path: "amis/",
        element: <Deconnexion />,
      },
      {
        path: "messages/",
        element: <Deconnexion />,
      },
      {
        path: "parametres/",
        element: <Deconnexion />,
      },
      {
        path: "deconnexion/",
        element: <Deconnexion />,
      },
    ];
  }, []);

  // Define routes accessible only to authenticated users
  const routesForAuthenticatedOnly = useMemo(() => {
    return [
      {
        path: "/",
        element: <ProtectedRoute></ProtectedRoute>,
        children: [
          {
            index: true,
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
  }, []);

  // Combine and conditionally include routes based on authentication status
  const router = createBrowserRouter([
    ...(auth.status === "connecte"
      ? routesForAuthenticatedOnly
      : routesForPublic),
  ]);

  // Provide the router configuration using RouterProvider
  return <RouterProvider router={router} />;
};

export default Routes;
