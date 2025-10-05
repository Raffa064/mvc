<?php

View::render("page", [
  "title" => "MVC: Post Editor",
  "styles" => ["editor"],
  "render" => function () use (&$post_title, &$post_content, &$error) { ?>
  <?php View::render("header"); ?>
  <form class="container flex-1" method="post">
    <div>
      <label>Title</label>
      <input name="post_title" value="<?= $post_title ?? "" ?>">
    </div>
    <div class="flex-1" style="display: flex; flex-direction: column;">
      <label>Content</label>
      <textarea name="post_content"><?= $post_content ?? "" ?></textarea>
    </div>

    <?php View::render("error-box", $error) ?>

    <div id="action-bar">
      <button class="clickable" type="submit">Post</button>
      <button class="clickable negative" type="button" onclick="history.back(); return false;">Cancel</button>
    </div>
  </form>

  <?php View::render("footer"); ?>
<?php
  }
]);
