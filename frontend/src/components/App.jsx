import { createBrowserRouter, RouterProvider } from "react-router-dom";
import Accueil from "./Accueil";
// import Profil from "./Profil";
import Deconnexion from "./Deconnexion";

import "/src/style/css/App.css";
import MainTemplate from "./MainTemplate";



const router = createBrowserRouter([
  {
    path: "/",
    element: <Accueil />,
  },
  {
    path: "profil/",
    element: <MainTemplate />,
  },
  {
    path: "deconnexion/",
    element: <Deconnexion />,
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
