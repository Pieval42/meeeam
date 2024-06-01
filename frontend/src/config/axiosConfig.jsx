import axios from "axios";
import { decodeToken } from "../utils/tokenService";

const axiosInstance = axios.create({
  baseURL: "http://localhost/meeeam/backend/index.php",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

axiosInstance.interceptors.request.use(
  (config) => {
    const accessToken = localStorage.getItem("meeeam_access_token");
    if (accessToken) {
      config.headers.Authorization = `Bearer ${accessToken}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
)

axiosInstance.interceptors.response.use(
  (response) => response,
  async (error) => {
    const originalRequest = error.config;

    // Si le code de réponse est 401 qu'il n'y a pas d'attribut originalRequest._retry,
    // cela signifie que le token est expiré et qu'il faut le rafraîchir.
    if (error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;

      try {
        const jsonPayload = decodeToken();
        
        if (jsonPayload) {
          const objectPayload = JSON.parse(jsonPayload);

          await axiosInstance
            .post("authentification/", {
              id_utilisateur: objectPayload.id_utilisateur,
              id_page_profil: objectPayload.id_page_profil,
              pseudo_utilisateur: objectPayload.pseudo_utilisateur,
              meeeam_refresh_token:
                "Refresh " + localStorage.getItem("meeeam_refresh_token"),
            })
            .then((response) => {
              if (response.data.status === "success") {
                console.log(response);
                localStorage.setItem(
                  "meeeam_access_token",
                  response.data.access_token
                );
                localStorage.setItem(
                  "meeeam_refresh_token",
                  response.data.refresh_token
                );
              } else {
                console.log(response.data.message);
              }
            })
            .catch((error) => {
              if (error.response.status === 498) {
                console.log(error.response.message);
              } else {
                console.error(error);
              }
            });
        }
        
        // Renvoie la requête originale avec le nouveau token
        originalRequest.headers.Authorization = `Bearer ${localStorage.getItem("meeeam_access_token")}`;
        return axios(originalRequest);
      } catch (error) {
        // Gestion des erreurs
        console.error(error);
      }
    }

    return Promise.reject(error);
  }
);

export default axiosInstance;
