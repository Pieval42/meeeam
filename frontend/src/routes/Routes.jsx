import { RouterProvider, createBrowserRouter } from "react-router-dom";
import { ProtectedRoute } from "./ProtectedRoute";
import { useAuth } from "../hooks/useAuth";
import { useContext, useEffect, useMemo } from "react";
import { authContext } from "../contexts/contexts";
import PageAccueil from "../pages/accueil/PageAccueil";
import PageProfil from "../pages/profil/PageProfil";
import PagePages from "../pages/pages/PagePages";
import PageAmis from "../pages/amis/PageAmis";
import PageMessages from "../pages/messages/PageMessages";
import PageParametres from "../pages/parametres/PageParametres";
import Deconnexion from "../pages/deconnexion/Deconnexion";

const Routes = () => {
  const auth = useAuth();
  const context = useContext(authContext);

  useEffect(() => {}, [context.status, context.erreurAuthentification]);

  // Define public routes accessible to all users
  const routesForPublic = useMemo(() => {
    return [
      {
        path: "/",
        element: <PageAccueil></PageAccueil>,
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
            element: <PageProfil />,
          },
          {
            path: "pages/",
            element: <PagePages />,
          },
          {
            path: "amis/",
            element: <PageAmis />,
          },
          {
            path: "messages/",
            element: <PageMessages />,
          },
          {
            path: "parametres/",
            element: <PageParametres />,
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
