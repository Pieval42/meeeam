import { createBrowserRouter, RouterProvider } from "react-router-dom";

import "/src/style/css/App.css";

import Accueil from "./Accueil";
import Profil from "./Profil";
import Deconnexion from "./Deconnexion";
import MainTemplate from "./MainTemplate";
import Pages from "./Pages";
import Amis from "./Amis";
import Messages from "./Messages";
import Parametres from "./Parametres";

const router = createBrowserRouter([
  {
    path: "/",
    element: (
      <Accueil />
    ),
  },
  {
    path: "main/",
    element: <MainTemplate />,
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
  
]);

function App() {
  return (
    <>
      <RouterProvider router={router} />
    </>
  );
}

export default App;
