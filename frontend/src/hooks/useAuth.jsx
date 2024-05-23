import { decodeToken } from "../utils/decodeToken";

export function useAuth() {
  let status = "inconnu";
  let tokenExpire = "true";

  const tokenPayload = decodeToken();

  tokenPayload &&
    (tokenExpire =
      JSON.parse(tokenPayload).exp < Math.floor(Date.now() / 1000));

  if (tokenExpire) {
    return { status: "nonConnecte", jsonPayload: tokenPayload };
  }
  switch (localStorage.getItem("meeeam_access_token") || null || undefined){
    case null:
      status = "nonConnecte";
      break;
    case undefined:
      status = "inconnu";
      break;
    default:
      status = "connecte";
  }

  return { status: status, jsonPayload: tokenPayload };
}
