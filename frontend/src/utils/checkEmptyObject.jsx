export function isEmpty(obj) {
  for(let prop in obj) {
    if(Object.hasOwn(obj, prop)){
      return false;
    }
  }
  return true;
}