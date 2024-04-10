export function useAuth(context = undefined) {
  let status = "inconnu"
  switch (context ? context.infosUtilisateurs : undefined) {
    case null:
      status = "nonConnecte";
      break;
    case undefined:
      status = "inconnu";
      break;
    default:
      status = "connecte";
  }

  return status
  
}
