<?php

View::render("page", [
  "title" => $title,
  "styles" => [],
  "render" => function () use (&$title, &$content, &$owner_name, &$owner_id) { ?>
  <?php View::render("header"); ?>

  <main class="container flex-1">
    <h1><?= $title ?></h1>
    <p><a href="/user?id=<?= $owner_id ?>"><?= $owner_name ?></a></p>
    <div><?= $content ?></div>
    <p><a href="#" onclick="history.back(); return false;">Go back</a></p>
  </main>

  <?php View::render("footer"); ?>
<?php }
]);
