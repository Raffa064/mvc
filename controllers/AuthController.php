<?php

class AuthController
{
  public static function login()
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "POST":
        $user_email = $_POST["user_email"];
        $user_password = $_POST["user_password"];

        if (UserModel::auth($user_email, $user_password) !== false) {
          View::redirect("/");
        } else {
          View::renderPage("Login", [
            "user_email" => $user_email,
            "error" => "Invalid creadentials"
          ]);
        }

        break;
      case "GET":
        View::renderPage("Login");
        break;
      default:
        View::error(ERR::METHOD_NOT_ALLOWED, "Your request could not be processed due to an invalid operation.");
    }
  }

  public static function signup()
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "POST":
        $user_name = $_POST["user_name"];
        $user_email = $_POST["user_email"];
        $user_password = $_POST["user_password"];

        if (UserModel::create($user_name, $user_email, $user_password, $err_msg)) {
          View::redirect("/"); // TODO: /wellcome?
        } else {
          View::renderPage("Signup", [
            "user_name" => $user_name,
            "user_email" => $user_email,
            "user_password" => $user_password,
            "error" => $err_msg
          ]);
        }
        break;
      case "GET":
        View::renderPage("Signup");
        break;
      default:
        View::error(ERR::METHOD_NOT_ALLOWED, "Your request could not be processed due to an invalid operation.");
    }
  }
}
