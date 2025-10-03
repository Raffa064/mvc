<?php

$errno = $DATA["err"]->value;
$errcode = $DATA["err"]->name;
$message = $DATA["message"];

View::render("page", [
  "title" => "Error $errno",
  "styles" => ["error"],
  "render" => function () use ($errno, $errcode, $message) {
?>
  <main>
    <h1><?= $errno ?> - Something went wrong...</h1>
    <p><?= $message ?></p>
    <p id="errcode">ERR_<?= $errcode ?></p>
    <p><a href="#" onclick="history.back(); return false;">Go back</a></p>
  </main>

<?php
  }
]);
