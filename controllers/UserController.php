<?php
class UserController
{
  public static function user()
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        $user_id = isset($_GET["id"]) ? $_GET["id"] : false;

        if (!$user_id || !is_numeric($user_id)) {
          View::error(ERR::BAD_REQUEST, "Can't locate user by id: '$user_id'");
          return;
        }

        $user = UserModel::get_by_id($user_id);

        if ($user)
          View::renderPage("User", $user);
        else
          View::error(ERR::NOT_FOUND, "User not found.");
        break;
      default:
        View::error(ERR::METHOD_NOT_ALLOWED, "Your request could not be processed due to an invalid operation.");
    }
  }

  public static function profile()
  {
    if (!AuthController::is_logged_in()) {
      View::redirect("/login");
      return;
    }

    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;

        echo "// TODO: Implement /profile?id=$user_id";
        break;
      default:
        View::error(ERR::METHOD_NOT_ALLOWED, "Your request could not be processed due to an invalid operation.");
    }
  }
}
