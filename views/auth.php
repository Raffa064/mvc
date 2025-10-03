<form id="auth-form" method="post" class="container-small" novalidate>
  <h1> <?= $title ?> </h1>

  <?php if (isset($user_name)): ?>
    <div>
      <label for="user_name">User name:</label><br>
      <input
        name="user_name"
        type="text"
        required
        minlength="<?= UserModel::$NAME_MIN_LENGTH ?>"
        maxlength="<?= UserModel::$NAME_MAX_LENGTH ?>"
        value="<?= $user_name ?>">
      <span class="error" id="user_name-error"></span>
    </div>
  <?php endif; ?>

  <?php if (isset($user_email)): ?>
    <div>
      <label for="user_email">Email:</label><br>
      <input
        name="user_email"
        type="email"
        required
        maxlength="<?= UserModel::$EMAIL_MAX_LENGTH ?>"
        value="<?= $user_email ?>">
      <span class="error" id="user_email-error"></span>
    </div>
  <?php endif; ?>

  <?php if (isset($user_password)): ?>
    <div>
      <label for="user_password">Password:</label><br>
      <input
        name="user_password"
        type="password"
        required
        minlength="<?= UserModel::$PASSWORD_MIN_LENGTH ?>"
        maxlength="<?= UserModel::$PASSWORD_MAX_LENGTH ?>"
        value="<?= $user_password ?>">
      <span class="error" id="user_password-error"></span>
    </div>
  <?php endif; ?>

  <?php if (isset($error) && $error): ?>
    <div id="post-error-dialog">
      <img src="/assets/error.svg" style="color: blue" height="20">
      <span class="flex-1">
        <?= $error ?>
      </span>
    </div>
  <?php endif; ?>

  <button class="clickable"> <?= $action ?> </button>

  <?php if (isset($opts)): ?>
    <div>
      <?php foreach ($opts as $opt): ?>
        <p><?= $opt["text"] ?> <a href="<?= $opt["uri"] ?>"><?= $opt["link-text"] ?></a> </p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php View::render("footer"); ?>
</form>

<script>
  const NAME_MIN_LENGTH = parseInt("<?= UserModel::$NAME_MIN_LENGTH ?>");
  const NAME_MAX_LENGTH = parseInt("<?= UserModel::$NAME_MAX_LENGTH ?>");
  const PASSWORD_MIN_LENGTH = parseInt("<?= UserModel::$PASSWORD_MIN_LENGTH ?>");
  const PASSWORD_MAX_LENGTH = parseInt("<?= UserModel::$PASSWORD_MAX_LENGTH ?>");

  const form = document.querySelector("#auth-form");

  form.addEventListener("submit", (e) => {
    form.querySelectorAll("input").forEach(input => {
      const errElt = form.querySelector(`#${input.name}-error`)

      const msg = validate(input.name, input.value);

      if (msg) {
        e.preventDefault();
        errElt.textContent = msg;
      }
    })
  })

  form.querySelectorAll("input").forEach(input => {
    input.addEventListener("input", () => {
      form.querySelector(`#${input.name}-error`).textContent = "";
    })
  })

  function validate(field, value) {
    console.log("val:", value);

    const validators = {
      "user_name": () => {
        if (value.length == 0)
          return "User name can't be empty!";

        if (value.length < NAME_MIN_LENGTH)
          return "This name is too short!";

        if (value.length > NAME_MAX_LENGTH)
          return "This name is too long!";

        if (!value.match(/^[a-zA-Z0-9_]+$/))
          return "Please, don't use any special character or spaces!";
      },
      "user_email": () => {
        if (value.length == 0)
          return "Email is a required field!";

        if (!value.match(/^[a-z0-9_.]+@[a-z0-9_.]+$/))
          return "Not a valid email";
      },
      "user_password": () => {
        if (value.length == 0)
          return "Password is a required field!";

        if (value.length < PASSWORD_MIN_LENGTH)
          return "It's too short!";

        if (value.length > PASSWORD_MAX_LENGTH)
          return "This password is too long!";
      }
    }

    return validators[field]()
  }
</script>
