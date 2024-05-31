<?php

require_once __DIR__ . "/../controllers/Authentification.controller.php";

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AuthentificationControllerTest extends TestCase
{
  private MockObject | AuthentificationController | null $authentificationController;
  // Valide jusqu'au 29/06/2024
  private $validAccessToken = "Bearer " . "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJtZWVlYW1fYXBpIiwic3ViIjoiYWNjZXNzX3Rva2VuIiwiYXVkIjoibWVlZWFtX3VzZXIiLCJpYXQiOjE3MTcwNjM0MDEsImV4cCI6MTcxOTY1NTQwMSwiaWRfdXRpbGlzYXRldXIiOjE3LCJpZF9wYWdlX3Byb2ZpbCI6NCwicHNldWRvX3V0aWxpc2F0ZXVyIjoiVmljdG9yIn0.b40YHnxTQyYR7aBwIrnaOPlLqllUYVVeLf_obE2PFWZUgFMmF9JZB73gNRKq4WOerXFSGk076fDvq95PzdjpIIuCMiO-3cD8R6cKtL_JfTvT_gpRC0kmk2G6uSJ11NOagQWOTfF54--wjDjYlNUxrRDd4O84nUYjJ_9xnOZe0E-mZlYLBQmoGarOJVVIaHWPxny7R0HbqQQVSYh-xdOSSp6Uy-NdRHW07lz71tlxYHHkVlXKQ_iM4FCOi7TWTSyNkhDmgijbb4WFsFkJR4EcMy3_x-6EokFVQByGYFj7UDtnkEwU_98a8Ebbu7KjVCtxVGitDlR-XjezvvR9rwmL3A";

  //Valide jusqu'au 29/07/2024
  private $validRefreshToken = "Refresh " . "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJtZWVlYW1fYXBpIiwic3ViIjoicmVmcmVzaCIsImF1ZCI6Im1lZWVhbV91c2VyIiwiaWF0IjoxNzE3MDYzNDAxLCJleHAiOjE3MjIyNDc0MDEsImlkX3V0aWxpc2F0ZXVyIjoxN30.kt_03jTW62_r7h2TLQNiNT79nZk35EH-_ACY10ke-1Pr5zHcjDBdOZg49-JvIqJBJ-AGzSzB4GCozjLpGU8WOZkP02yfqOlC_ehe1iHYSl-f5fClHbdBUWQo3SMHYVN7NW6oVwYD22iXgktU_P6mjOY4UKtIRuZRjxixugfmcNg1oB8oRerWPkhnPOJgSuKdx3hvhedA2kK7WcWbBR6TofiLDEOjIiGzCIoMHilUrU7fQkNYvZVDF2yPkOBakWmnGm_MPH41IrhePxrbIiCyVE3amTlIhoCZV_zBQ44nZspBmCPgxL6UeFGlYAgrKIALVHs_CHNlb_FW-Cx0HX6c9Q";

  //Expiré le 30/05/2024
  private $invalidAccessToken = "Bearer " . "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJtZWVlYW1fYXBpIiwic3ViIjoiYWNjZXNzX3Rva2VuIiwiYXVkIjoibWVlZWFtX3VzZXIiLCJpYXQiOjE3MTcwODk4MDIsImV4cCI6MTcxNzA4OTgwOCwiaWRfdXRpbGlzYXRldXIiOjE3LCJpZF9wYWdlX3Byb2ZpbCI6NCwicHNldWRvX3V0aWxpc2F0ZXVyIjoiVmljdG9yIn0.Ptzc75amQt18M5tc-PGzoMl1KjsakdFdl1W9KdDk8Q_XfjUkL6zW0a78E9rWqsDVLckiZf__zFcsfVZSF9qJlnA7vxh1vUFVceRYPdDVadKD9E5kbYzTceVvMhbZJw_DVlWYYnJ1FKDTVWLCnsjaxGSUO6ZXZTa3wjEejXqFzq3NlG-2gbIwJ8N-_hj2eQ2bObyXDFyj80nBYRM14Yp613uUCHUBwcsqKTdDxadaWvWBN7OEmNepIe0IvPJ-y74Yd9Y4zhhyNYiLxU7tkQEzSqGFoVMKIWlyPfpWHpT8I8_Hlasea3LQBGKQS7eFeX1V-OlUXPUFRSLg8J9-EsCAgg";

  //Expiré le 30/05/2024
  private $invalidRefreshToken = "Refresh " . "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJtZWVlYW1fYXBpIiwic3ViIjoicmVmcmVzaCIsImF1ZCI6Im1lZWVhbV91c2VyIiwiaWF0IjoxNzE3MDkxMTMwLCJleHAiOjE3MTcwOTExMzYsImlkX3V0aWxpc2F0ZXVyIjoxN30.P3nyLLWoxEKVryjTgNbbQgPzFnQC3q1VzQCCBNBKcDH3EqmesDmyyZ9wbXsJS57k71rrwFD6Hk-fNQlvpkWLi2por5Si5cHvL8sbnsEO33fTfvqrSzjjKmuNMZLW3jChYOpfWXearO2uv834joGLGTzWXOxrYv2_Srw2zTwsBeWpriO8gGniNhnLU_65AaijVhTGf7jDGq7oTipgkTrZAbJ0oohHeySlB0QYBH4sJsp4lZHJXI_C1JRMCxxkuEOO3TQIJRYOWcIrABiv3B-yt_jP_1c8_kGEII_rYiLEISNizB374bKNY5B8scbMSfBQmBP62I7hV5qzLXnzEkx9sQ";

  protected function setUp(): void
  {
    $this->authentificationController = $this->getMockBuilder(AuthentificationController::class)
      ->onlyMethods(['getRawRequestBody', 'createAccessToken', 'createRefreshToken'])
      ->getMock();
  }

  public function testAuthentificationSuccessWithAccesAndRefreshValid()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_SERVER["HTTP_AUTHORIZATION"] = $this->validAccessToken;
    $inputData = [
      'id_utilisateur' => 17,
      'id_page_profil' => 4,
      'pseudo_utilisateur' => 'Victor',
      'meeeam_refresh_token' => $this->validRefreshToken
    ];

    $this->authentificationController->expects($this->once())
      ->method('getRawRequestBody')
      ->willReturn($inputData);

    $this->authentificationController->expects($this->once())
      ->method('createAccessToken')
      ->willReturn('new_access_token');

    $this->authentificationController->expects($this->once())
      ->method('createRefreshToken')
      ->willReturn('new_refresh_token');

    ob_start();
    $this->authentificationController->authentification();
    $output = ob_get_clean();

    $this->assertEquals(json_encode([
      'status' => 'success',
      'message' => 'Authentification réussie.',
      'data' => [
        'id_utilisateur' => 17,
        'id_page_profil' => 4,
        'pseudo_utilisateur' => 'Victor'
      ],
      'access_token' => 'new_access_token',
      'refresh_token' => 'new_refresh_token'
    ]), $output);
  }

  public function testAuthentificationSuccessWithAccessInvalid()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_SERVER["HTTP_AUTHORIZATION"] = $this->invalidAccessToken;
    $inputData = [
      'id_utilisateur' => 17,
      'id_page_profil' => 4,
      'pseudo_utilisateur' => 'Victor',
      'meeeam_refresh_token' => $this->validRefreshToken
    ];

    $this->authentificationController->expects($this->once())
      ->method('getRawRequestBody')
      ->willReturn($inputData);

    $this->authentificationController->expects($this->once())
      ->method('createAccessToken')
      ->willReturn('new_access_token');

    $this->authentificationController->expects($this->once())
      ->method('createRefreshToken')
      ->willReturn('new_refresh_token');

    ob_start();
    $this->authentificationController->authentification();
    $output = ob_get_clean();

    $this->assertEquals(json_encode([
      'status' => 'success',
      'message' => 'Authentification réussie.',
      'data' => [
        'id_utilisateur' => 17,
        'id_page_profil' => 4,
        'pseudo_utilisateur' => 'Victor'
      ],
      'access_token' => 'new_access_token',
      'refresh_token' => 'new_refresh_token'
    ]), $output);
  }

  public function testAuthentificationInvalidTokens()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_SERVER["HTTP_AUTHORIZATION"] = $this->invalidAccessToken;
    $inputData = [
      'id_utilisateur' => 17,
      'id_page_profil' => 4,
      'pseudo_utilisateur' => 'Victor',
      'meeeam_refresh_token' => $this->invalidRefreshToken
    ];

    $this->authentificationController->expects($this->once())
      ->method('getRawRequestBody')
      ->willReturn($inputData);

    ob_start();
    $this->authentificationController->authentification();
    $output = ob_get_clean();

    $this->assertEquals(json_encode([
      'status' => 'error',
      'message' => 'Refresh token invalide.',
      'data' => [],
      'access_token' => null,
      'refresh_token' => null
    ]), $output);
  }

  public function testOptionsRequest()
  {
    $_SERVER["REQUEST_METHOD"] = "OPTIONS";

    ob_start();
    $this->authentificationController->authentification();
    $output = ob_get_clean();

    $this->assertEquals(
      json_encode([
        'status' => 'success',
        'message' => 'Requête OPTIONS autorisée.',
        'data' => [],
        'access_token' => null,
        'refresh_token' => null
      ]),
      $output
    );
  }

  public function testBadRequest()
  {
    $_SERVER["REQUEST_METHOD"] = isset($_SERVER["REQUEST_METHOD"]) ? "GET" : $_SERVER[] = ["REQUEST_METHOD" => "GET"];

    ob_start();
    $this->authentificationController->authentification();
    $output = ob_get_clean();

    $this->assertEquals(
      json_encode([
        'status' => 'error',
        'message' => 'Mauvaise requête.',
        'data' => [],
        'access_token' => null,
        'refresh_token' => null
      ]),
      $output
    );
    $_SERVER["REQUEST_METHOD"] = "";
    $_SERVER["HTTP_AUTHORIZATION"] = "";
  }

  public function tearDown(): void
  {
    $this->authentificationController = null;
  }
}
