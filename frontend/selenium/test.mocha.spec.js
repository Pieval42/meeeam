/* eslint-disable no-undef */
import { Browser, By, until } from "selenium-webdriver";
import * as edge from "selenium-webdriver/edge.js";
import * as chrome from "selenium-webdriver/chrome.js";
import * as firefox from "selenium-webdriver/firefox.js";
import * as testing from "selenium-webdriver/testing/index.js";

const edgeOptions = new edge.Options();
const chromeOptions = new chrome.Options();
const firefoxOptions = new firefox.Options();

testing.suite(
  (env) => {
    describe("Test de connexion et déconnexion sur différents navigateurs", () => {
      it("should navigate to login modal, login and logout", async () => {
        let driver = await env
          .builder()
          .setEdgeOptions(edgeOptions.addArguments("--start-maximized"))
          .setChromeOptions(chromeOptions.addArguments("--start-maximized"))
          .setFirefoxOptions(firefoxOptions.addArguments("--kiosk"))
          .build();
        try {
          await driver.get("http://localhost:8080");
          await driver
            .findElement(By.className("btn-custom-secondary"))
            .click();
          await driver.wait(until.elementLocated(By.className("modal-dialog")));
          const buttonLogin = await driver.findElement(
            By.id("btn-submit-login-form")
          );
          await buttonLogin.click();
          await driver.wait(until.elementLocated(By.className("text-warning")));
          await driver
            .findElement(By.id("login-email-input"))
            .sendKeys("victor@test.com");
          await driver
            .findElement(By.id("login-password-input"))
            .sendKeys("Password123!");
          await buttonLogin.click();
          await driver.wait(until.elementLocated(By.id("header-btn-dropdown")));
          await driver.findElement(By.id("header-btn-dropdown")).click();
          await driver.wait(
            until.elementLocated(By.id("header-link-to-deconnexion"))
          );
          await driver.findElement(By.id("header-link-to-deconnexion")).click();
          await driver.wait(
            until.elementLocated(By.id("btn-back-to-home-after-logout"))
          );
          await driver.findElement(By.id("btn-back-to-home-after-logout")).click();
          await driver.wait(
            until.elementLocated(By.id("btn-open-signup-page"))
          );
          await driver.findElement(By.id("btn-open-signup-page")).click();
          await driver.wait(
            until.elementLocated(By.id("btn-submit-signup-form"))
          );
        } finally {
          setTimeout(() => {
            driver.quit();
          }, 2000);
        }
      });
    });
  },
  { browsers: [Browser.EDGE, Browser.CHROME, Browser.FIREFOX] }
);
