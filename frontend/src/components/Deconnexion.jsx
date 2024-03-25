import axios from 'axios';

export default function Deconnexion() {
  axios.post('http://localhost:42600/backend/index.php/connexion')
  .then(() => {
    sessionStorage.clear();
    window.location.href = '/';
  })
  .catch((error) => {
     console.error(error);
  });
}
