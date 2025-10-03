<?php

// Import everything
require __DIR__ . "/../import.php";

$uri = $_SERVER["REQUEST_URI"];
$uri = explode("?", $uri)[0];

switch ($uri) {
  case "/":
    View::renderPage("Home");
    break;
  case "/login":
    AuthController::login();
    break;
  case "/signup":
    AuthController::signup();
    break;
  default:
    View::error(ERR::NOT_FOUND, "Could not locate requested resource: $uri");
}
