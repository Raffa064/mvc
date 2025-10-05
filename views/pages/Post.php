<?php

$post = $DATA;

function format_content_html($content)
{
  $content = htmlspecialchars($content);
  $content = str_replace("\n", "<br>", $content);

  return $content;
}

View::render("page", [
  "title" => $post->title,
  "styles" => ["post"],
  "render" => function () use ($post) { ?>
  <?php View::render("header"); ?>

  <main class="container flex-1">
    <h1><?= htmlspecialchars($post->title) ?></h1>
    <div>
      <a href="/user?id=<?= $post->owner_id ?? "#" ?>"><?= htmlspecialchars($post->owner_name ?? "<Deleted user>") ?></a>
    </div>
    <div id="content"><?= format_content_html($post->content) ?></div>
    <p><?php View::render("go-back") ?></p>
  </main>

  <?php View::render("footer"); ?>
<?php }
]);
