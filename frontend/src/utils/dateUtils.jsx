export function convertSqlDateTimeToFr(date) {
    const dhm = date.split(/[- :]/);
    const convertedDate = new Date(
      Date.UTC(dhm[0], dhm[1] - 1, dhm[2], dhm[3] , dhm[4], dhm[5]),
    ).toLocaleString("fr-FR", { timeZone: "CET" });
    return convertedDate;
}

export function calculateAge(birthDateString) {
  // Convertit la chaîne de date en un objet Date
  const birthDate = new Date(birthDateString);
  const today = new Date();

  // Calcule la différence en années
  let age = today.getFullYear() - birthDate.getFullYear();

  // Ajuste l'âge si la date anniversaire n'a pas encore été atteinte cette année
  const monthDifference = today.getMonth() - birthDate.getMonth();
  if (
    monthDifference < 0 ||
    (monthDifference === 0 && today.getDate() < birthDate.getDate())
  ) {
    age--;
  }

  return age;
}
