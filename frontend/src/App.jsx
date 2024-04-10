import AuthProvider from "./provider/AuthProvider";
import Routes from "./routes/Routes";

import "/src/style/css/App.css";

export default function App() {
  
  return (
    <AuthProvider>
      <Routes />
    </AuthProvider>
  );
}
