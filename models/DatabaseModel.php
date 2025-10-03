<?php


function load_json(string $path): ?array
{
  $file = fopen($path, "r");

  if ($file) {
    $json = fread($file, filesize($path));
    return json_decode($json, true);
  }

  return null;
}

class DatabaseModel
{
  private static ?PDO $db = null;

  public static function init(string $cfg_path): void
  {
    if (self::$db != null)
      die("Database connection is being initialized twice!");

    $config = load_json($cfg_path);

    self::$db = new PDO("mysql:host=$config[host];dbname=$config[database]", $config["user"], $config["password"]);
  }

  public static function query(string $sql, array $params): array|bool
  {
    try {
      $statment = self::$db->prepare($sql);

      if ($statment !== false) {
        $status = $statment->execute($params);

        if ($status) {
          $result = $statment->fetchAll(PDO::FETCH_ASSOC);

          // Some queries (like INSERT) does't retrieves a Result set
          if ($result === false)
            return true;

          return $result;
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    return false;
  }

  public static function last_insert_id(): int | false
  {
    return self::$db->lastInsertId();
  }
}

DatabaseModel::init(__DIR__ . "/../config.json");
