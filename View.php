<?php

class View
{
  public static function render(string $view, $DATA = null)
  {
    $path = __DIR__ . "/views/" . $view . ".php";

    if (is_file($path)) {
      if (is_array($DATA))
        extract($DATA, EXTR_SKIP);

      require $path;

      return;
    }

    self::error(ERR::NOT_FOUND, "Render Error: Can't locate view: $view");
  }

  public static function renderPage(string $page, $DATA = null)
  {
    self::render("pages/$page", $DATA);
  }


  public static function redirect($uri)
  {
    header("Location: $uri");
    exit;
  }

  public static function error(ERR $err, string $message)
  {
    http_response_code($err->value ?? 500);
    self::renderPage("Error", [
      "err" => $err,
      "message" => $message
    ]);
  }
}
