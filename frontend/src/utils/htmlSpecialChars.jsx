const specialCharsMap = {
  "&amp;": "&",
  "&#038;": "&",
  "&quot;": "\"",
  "&#039;": "'",
  "&lt;": "<",
  "&gt;": ">",
};

export function decodeHtmlSpecialChars(text) {
  return text.replace(/&[\w\d#]{2,4};/g, (key) => {
    return specialCharsMap[key];
  });
}

export function encodeHtmlSpecialChars(text) {
  return text.replace(/[&"'<>]/g, (value) => {
    return Object.keys(specialCharsMap).find(
      (key) => specialCharsMap[key] === value
    );
  });
}
