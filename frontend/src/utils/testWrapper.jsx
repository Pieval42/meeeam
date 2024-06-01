import { render as rtlRender } from "@testing-library/react"; 
import App from "../App";

// eslint-disable-next-line react/prop-types
function Wrapper({ children }) {
  return <App>{ children }</App>
}

export function render(ui) {
  rtlRender(ui, { wrapper: Wrapper })
}