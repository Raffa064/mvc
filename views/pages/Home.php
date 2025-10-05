<?php

$posts = PostModel::list_recent();

View::render("page", [
  "title" => "Home",
  "styles" => ["home"],
  "render" => function () use ($posts) {
?>
  <?php View::render("header"); ?>

  <main class="container flex-1">
    <?php if (!is_null($posts)): ?>
      <ol id="post-list">
        <?php foreach ($posts as $post) {
          View::render("post-item", $post);
        } ?>
      </ol>
    <?php else: ?>
      <?php View::render("error-box", "Could not retrieve post history"); ?>
    <?php endif; ?>
  </main>

  <?php View::render("footer"); ?>
<?php
  }
]);
