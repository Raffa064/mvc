<?php

View::render("page", [
  "title" => "Login",
  "styles" => ["auth"],
  "render" => function () use (&$user_email, &$error) {
    View::render("header");
    View::render("auth", [
      "title" => "Login",
      "user_email" => $user_email ?? "",
      "user_password" => "",
      "error" => $error,
      "action" => "Login",
      "opts" => [
        [
          "uri" => "/signup",
          "text" => "Don't have an account?",
          "link-text" => "Signup instead."
        ]
      ]
    ]);
  }
]);
