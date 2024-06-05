import { describe, it } from "vitest";
import Inscription from "./Inscription.jsx";
import { render } from "../../utils/testWrapper";
import { fireEvent, screen } from "@testing-library/react";

describe("Test de la page d'inscription", () => {
  it("should render without crash", async () => {
    render(<Inscription />);
    const goToSignUpPageButton = screen.getByTestId("goToSignUpPageButton");
    fireEvent.click(goToSignUpPageButton);
    const signUpButton = screen.getByTestId("signUpButton");
    fireEvent.click(signUpButton);
  });
});
