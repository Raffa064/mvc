<?php

class UserModel
{
  public int $id;
  public string $name;
  public string $email;
  public string $password;

  public static int $NAME_MIN_LENGTH = 3;
  public static int $NAME_MAX_LENGTH = 32;
  public static int $PASSWORD_MIN_LENGTH = 8;
  public static int $PASSWORD_MAX_LENGTH = 32;
  public static int $EMAIL_MAX_LENGTH = 256;

  private function __construct(int $id = -1, string $name, string $email, string $password)
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
  }

  public static function create(string $name, string $email, string $password, ?string &$err_msg, ?UserModel &$user): bool
  {
    $err_msg = null;
    $user = null;

    if (
      strlen($name) < self::$NAME_MIN_LENGTH ||
      strlen($name) > self::$NAME_MAX_LENGTH ||
      !preg_match("/^[a-zA-Z0-9_]+$/", $name)
    ) {
      $err_msg = "Invalid user name.";
      return false;
    }

    if (
      strlen($email) > self::$EMAIL_MAX_LENGTH ||
      !preg_match("/^[a-z0-9_.]+@[a-z0-9_.]+$/", $email)
    ) {
      $err_msg = "Invalid email.";
      return false;
    }

    if (
      strlen($password) < self::$PASSWORD_MIN_LENGTH ||
      strlen($password) > self::$PASSWORD_MAX_LENGTH
    ) {
      $err_msg = "Invalid password length.";
      return false;
    }

    $sql = "INSERT INTO users(name, email, password) VALUES (?, ?, ?);";
    $result = DatabaseModel::query($sql, [$name, $email, $password]);

    if ($result === false) {
      $err_msg = "Something went wrong. This <span style='text-decoration: underline'>email</span> or <span style='text-decoration: underline'>username</span> may be already in use.";
      return false;
    }

    $user = new UserModel(
      DatabaseModel::last_insert_id(),
      $name,
      $email,
      $password
    );

    return true;
  }

  public static function auth(string $email, string $password, ?UserModel &$user): int | false
  {
    $user = null;

    $sql = "SELECT * from users WHERE email = ?;";
    $result = DatabaseModel::query($sql, [$email]);

    if ($result === false || count($result) != 1)
      return false;

    $data = $result[0];

    if ($password == $data["password"]) {
      $user = new UserModel(
        $data["id"],
        $data["name"],
        $data["email"],
        $data["password"]
      );

      return true;
    }

    return false;
  }
}
