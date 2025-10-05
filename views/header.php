<header>
  <a href="/"><span id="logo">MVC</span></a>
  <span class="flex-1"></span>
  <nav>
    <?php if (!AuthController::is_logged_in()): ?>
      <a href="/login">Login</a>
      <a href="/signup">Signup</a>
    <?php else: ?>
      <a class="clickable" href="/create">
        <img src="/assets/add.svg" height="24">
        <div class="tooltip">
          Write a new post
        </div>
      </a>

      <a class="clickable" href="/profile">
        <img src="/assets/account.svg" height="24">
        <div class="tooltip">
          View profile
        </div>
      </a>

      <a class="clickable" href="/logout">
        <img src="/assets/logout.svg" height="24">
        <div class="tooltip">
          Logout
        </div>
      </a>
    <?php endif ?>

  </nav>
</header>
