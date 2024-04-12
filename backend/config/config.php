<?php

define("DB_INFOS", "mysql:host=localhost;dbname=test_meeeam;charset=utf8");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");

define("PROJECT_ROOT_PATH", __DIR__ . "/../");

define("SERVER_PORT", "42600");
define("FRONT_END_SERVER", "http://localhost:8080/");

try {
    $privateKey = file_get_contents('C:/Users/pieva/.ssh/private.pem');
    define("PRIVATE_KEY", $privateKey);

    $publicKey = file_get_contents('C:/Users/pieva/.ssh/public.pem');
    define("PUBLIC_KEY", $publicKey);

} catch(Error $e) {
    echo $e;
}
?>