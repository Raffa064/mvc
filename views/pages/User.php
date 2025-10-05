<?php

$user = $DATA;
$user_posts = PostModel::list_posts_by_owner_id($user->id);

View::render("page", [
  "title" => $user->name,
  "styles" => ["user", "post-list"],
  "render" => function () use ($user, $user_posts) {
?>
  <?php View::render("header") ?>
  <main class="container flex-1">
    <h1><?= $user->name ?></h1>
    <ol id="post-list">
      <?php foreach ($user_posts as $post): ?>
        <?php View::render("post-item", $post); ?>
      <?php endforeach; ?>
    </ol>
    <?php View::render("go-back"); ?>
  </main>
  <?php View::render("footer") ?>
<?php
  }
]);
