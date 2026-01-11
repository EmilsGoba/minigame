<?php

$routes = require("routes.php");

$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require "controllers/404.php";
    die();
}