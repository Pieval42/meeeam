export function decodeToken() {
  const tokenEncoded = localStorage.getItem("Bearer");
  if (tokenEncoded) {
    const base64Url = tokenEncoded.split(".")[1];
    const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
    const jsonPayload = decodeURIComponent(
      window
        .atob(base64)
        .split("")
        .map(function (c) {
          return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
        })
        .join(""),
    );
    return jsonPayload;
  }
  return null;
}
