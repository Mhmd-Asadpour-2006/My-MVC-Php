<?php

define("APP_NAME" , "MY MVC");
define("BASE_URL", "https://$_SERVER[HTTP_HOST]:8000");
define("BASE_PATH", realpath(__DIR__ . "/.."));
define("CURRENT_ROOT",substr(explode("?", $_SERVER['REQUEST_URI'])[0], 1) ); // delete first / && extract root

global $routes;
$routes = [
    "get" => [],
    "post" => [],
    "put" => [],
    "delete" => [],
];