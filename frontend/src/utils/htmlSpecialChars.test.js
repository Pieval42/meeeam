import { describe, expect, it } from "vitest";
import {
  decodeHtmlSpecialChars,
  encodeHtmlSpecialChars,
} from "./htmlSpecialChars";

describe("encode and decode html special characters", () => {
  it("should decode special characters", () => {
    expect(
      decodeHtmlSpecialChars(
        "&lt;test&gt;&quot;&amp;&#038;&#039;test&#039;&quot;"
      )
    ).toBe("<test>\"&&'test'\"");
  });

  it("should encode special characters", () => {
    expect(encodeHtmlSpecialChars("<test>\"&&'test'\"")).toBe(
      "&lt;test&gt;&quot;&amp;&amp;&#039;test&#039;&quot;"
    );
  });
});
