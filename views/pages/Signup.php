<?php

View::render("page", [
  "title" => "Signup",
  "styles" => ["auth"],
  "render" => function () use (&$user_name, &$user_email, &$user_password, &$error) {
    View::render("header");
    View::render("auth", [
      "title" => "Signup",
      "user_name" => $user_name ?? "",
      "user_email" => $user_email ?? "",
      "user_password" => $user_password ?? "",
      "error" => $error ?? "",
      "action" => "Signup",
      "opts" => [
        [
          "uri" => "/login",
          "text" => "Already have an account?",
          "link-text" => "Login instead"
        ]
      ]
    ]);
  },
]);
