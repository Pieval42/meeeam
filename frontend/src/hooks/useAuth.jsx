export function useAuth() {
  let status = "inconnu";
  let tokenExpire = "true";
  let jsonPayload = null;
  const tokenEncoded = localStorage.getItem("Bearer");

  if(tokenEncoded) {
    const base64Url = tokenEncoded.split(".")[1];
    const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
    jsonPayload = decodeURIComponent(
      window
        .atob(base64)
        .split("")
        .map(function (c) {
          return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
        })
        .join(""),
    );

    tokenExpire = JSON.parse(jsonPayload).exp < Math.floor(Date.now()/1000);

  }
  
  if (tokenExpire) {
    return {status: "nonConnecte", jsonPayload: jsonPayload}
  }
  switch ((localStorage.getItem("Bearer") || null || undefined)) {
    case null:
      status = "nonConnecte";
      break;
    case undefined:
      status = "inconnu";
      break;
    default:
      status = "connecte";
  }

  return {status: status, jsonPayload: jsonPayload};
}
