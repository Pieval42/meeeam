import axios from "axios";

export const axiosInstance = axios.create({
  baseURL: "http://localhost:42600/backend/index.php",
  timeout: 1000,
  headers: {
    "Content-Type": "application/json",
    Authorization: `Bearer ${localStorage.getItem("Bearer")}`,
    Accept: "application/json",
  },
});
