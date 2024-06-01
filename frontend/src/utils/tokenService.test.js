import { beforeEach, describe, expect, it } from "vitest";
import * as tokenService from "./tokenService";

describe("decode token payload", () => {
  beforeEach(() => {
    localStorage.clear();
  });

  it("should decode the payload", () => {
    const mockToken =
      "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJtZWVlYW1fYXBpIiwic3ViIjoiYWNjZXNzX3Rva2VuIiwiYXVkIjoibWVlZWFtX3VzZXIiLCJpYXQiOjE3MTcwNjM0MDEsImV4cCI6MTcxOTY1NTQwMSwiaWRfdXRpbGlzYXRldXIiOjE3LCJpZF9wYWdlX3Byb2ZpbCI6NCwicHNldWRvX3V0aWxpc2F0ZXVyIjoiVmljdG9yIn0.b40YHnxTQyYR7aBwIrnaOPlLqllUYVVeLf_obE2PFWZUgFMmF9JZB73gNRKq4WOerXFSGk076fDvq95PzdjpIIuCMiO-3cD8R6cKtL_JfTvT_gpRC0kmk2G6uSJ11NOagQWOTfF54--wjDjYlNUxrRDd4O84nUYjJ_9xnOZe0E-mZlYLBQmoGarOJVVIaHWPxny7R0HbqQQVSYh-xdOSSp6Uy-NdRHW07lz71tlxYHHkVlXKQ_iM4FCOi7TWTSyNkhDmgijbb4WFsFkJR4EcMy3_x-6EokFVQByGYFj7UDtnkEwU_98a8Ebbu7KjVCtxVGitDlR-XjezvvR9rwmL3A";
    const expectedPayload =
      '{"iss":"meeeam_api","sub":"access_token","aud":"meeeam_user","iat":1717063401,"exp":1719655401,"id_utilisateur":17,"id_page_profil":4,"pseudo_utilisateur":"Victor"}';

    localStorage.setItem("meeeam_access_token", mockToken);

    const tokenDecoded = tokenService.decodeToken();

    expect(tokenDecoded).toBe(expectedPayload);
  });

  it("should return null if there isn't any token in localStorage", () => {
    const tokenDecoded = tokenService.decodeToken();

    expect(tokenDecoded).toBeNull;
  });
});
