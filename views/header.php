<header>
  <span id="logo">MVC</span>
  <span class="flex-1"></span>
  <nav>
    <a href="/">Home</a>

    <?php if (!AuthController::is_logged_in()): ?>
      <a href="/login">Login</a>
      <a href="/signup">Signup</a>
    <?php else: ?>
      <a href="/profile">Profile</a>
      <a href="/logout">Logout</a>
    <?php endif ?>

  </nav>
</header>
