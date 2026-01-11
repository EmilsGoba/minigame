<?php
$routes = require("routes.php");
$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

// NEW: Allow static files (CSS/JS) to bypass the router
$publicFile = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($publicFile) && is_file($publicFile)) {
    return false; 
}

if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require "controllers/404.php";
    die();
}