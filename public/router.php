<?php

// Import everything
require __DIR__ . "/../import.php";

$uri = $_SERVER["REQUEST_URI"];
$uri = explode("?", $uri)[0];

AuthController::start_session();

switch ($uri) {
  case "/":
    View::renderPage("Home");
    break;
  case "/signup":
    AuthController::signup();
    break;
  case "/login":
    AuthController::login();
    break;
  case "/logout":
    AuthController::logout();
    break;
  case "/create":
    PostController::create();
    break;
  case "/post":
    PostController::post();
    break;
  case "/user":
    UserController::user();
    break;
  case "/profile":
    UserController::profile();
    break;
  default:
    View::error(ERR::NOT_FOUND, "Could not locate requested resource: $uri");
}
