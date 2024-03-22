import Accueil from './Accueil'
import MainTemplate from './MainTemplate'

import '/src/style/css/App.css'

function App() {

  const isLogged = true;
  
  return (
    <>
      {isLogged ? <MainTemplate /> : <Accueil />}
    </>
  );
}

export default App
