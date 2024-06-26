import AuthProvider from "./provider/AuthProvider";
import Routes from "./routes/Routes";

export default function App() {
  return (
    <AuthProvider>
      <Routes />
    </AuthProvider>
  );
}
