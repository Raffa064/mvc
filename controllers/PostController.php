<?php

class PostController
{
  public static function create()
  {
    if (!AuthController::is_logged_in())
      View::redirect("/login");

    switch ($_SERVER["REQUEST_METHOD"]) {
      case "POST":
        $post_owner_id = $_SESSION["user_id"];
        $post_title = $_POST["post_title"];
        $post_content = $_POST["post_content"];

        if (PostModel::create_post($post_owner_id, $post_title, $post_content, $err_msg, $post)) {
          View::redirect("/"); // TODO: go to post page instead
        } else {
          View::renderPage("PostEditor", [
            "post_title" => $post_title,
            "post_content" => $post_content,
            "error" => $err_msg
          ]);
        }
        break;
      case "GET":
        View::renderPage("PostEditor");
        break;
      default:
        View::error(ERR::METHOD_NOT_ALLOWED, "Your request could not be processed due to an invalid operation.");
    }
  }

  public static function post()
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        $post_id = isset($_GET["id"]) ? $_GET["id"] : false;

        if (!$post_id || !is_numeric($post_id)) {
          View::error(ERR::BAD_REQUEST, "Can't locate post by id: '$post_id'");
          return;
        }

        $post = PostModel::get_by_id($post_id);

        View::renderPage("Post", $post);
        break;
      default:
        View::error(ERR::METHOD_NOT_ALLOWED, "Your request could not be processed due to an invalid operation.");
    }
  }
}
