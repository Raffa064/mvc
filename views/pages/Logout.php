<?php

View::render("page", [
  "title" => "Logout",
  "styles" => ["logout"],
  "render" => function () {
    View::render("header");
?>
  <form class="container-small" method="post">
    <h1>We'll all miss you!</h1>
    <p>Do you really want to logout?</p>
    <div style="display: flex; flex-direction: row; gap: 10px; justify-content: right; align-items: center;">
      <button class="clickable">Yes</button>
      <a href="#" onclick="history.back(); return false;">No, cancel</a>
    </div>
    <?php View::render("footer"); ?>
  </form>
<?php
  }
]);
