<?php

class PostModel
{
  public int $id;
  public ?int $owner_id;        // A user could be deleted, and their posts remains
  public ?string $owner_name;
  public ?int $root_id;         // When it's set, it means that the post is a comment 
  public ?int $reply_id;        // If set, the post is an reply to another comment
  public string $title;
  public ?string $content;      //  Can only be null if on a parcail view
  public DateTime $created_at;

  public static int $TITLE_MAX_LENGTH = 32;
  public static int $CONTENT_MIN_LENGTH = 100;

  public function __construct($id, $owner_id, $owner_name, $root_id, $reply_id, $title, $content, $created_at)
  {
    $this->id = $id;
    $this->owner_id = $owner_id;
    $this->owner_name = $owner_name;
    $this->root_id = $root_id;
    $this->reply_id = $reply_id;
    $this->title = $title;
    $this->content = $content;
    $this->created_at = $created_at;
  }

  public function is_comment(): bool
  {
    return !is_null($this->root_id);
  }

  public function is_reply(): bool
  {
    return $this->is_comment() && !is_null($this->reply_id);
  }


  public static function create(?int $owner_id, ?int $root_id, ?int $reply_id, string $title, string $content, ?string &$err_msg, ?int &$post_id): bool
  {
    $err_msg = null;
    $post_id = null;

    if (is_null($root_id) && !is_null($reply_id)) {
      $err_msg = "Invalid post state: could not reply on a inexistent post.";
      return false;
    }

    if ($title == "" || is_null($title)) {
      $err_msg = "Post title must be set.";
      return false;
    }

    if ($content == "" || is_null($content) || strlen($content) < self::$CONTENT_MIN_LENGTH) {
      $err_msg = "There is no enough content on the post to be accepted.";
      return false;
    }

    $now = new DateTime();
    $created_at = $now->format("Y-d h:i:s");

    $sql = "INSERT INTO posts(owner_id, root_id, reply_id, title, content, created_at) VALUES (?, ?, ?, ?, ?);";
    $result = DatabaseModel::query($sql, [$owner_id, $root_id, $reply_id, $title, $content, $created_at]);

    if ($result === false) {
      $err_msg = "Could not post.";
      return false;
    }

    $post_id = DatabaseModel::last_insert_id();

    return true;
  }

  public static function create_post($owner_id, string $title, string $content, ?string &$err_msg, ?int &$post_id): bool
  {
    return self::create($owner_id, null, null, $title, $content, $err_msg, $post_id);
  }

  public static function list_recent_posts(): array|false
  {
    $sql = "SELECT * FROM post_view ORDER BY id DESC LIMIT 100;";
    $result = DatabaseModel::query($sql, []);

    return array_map(fn($p) => self::from_array($p), $result);
  }

  public static function get_post_by_id(int $id): PostModel|false
  {
    $sql = "SELECT * FROM post_content_view WHERE id = ?;";
    $result = DatabaseModel::query($sql, [$id]);

    if ($result === false || count($result) != 1)
      return false;

    return self::from_array($result[0]);
  }

  public static function list_posts_by_owner_id(int $id): array|bool
  {
    $sql = "SELECT * FROM post_view WHERE owner_id = ? ORDER BY id DESC;";
    $result = DatabaseModel::query($sql, [$id]);

    if ($result === false)
      return false;

    return array_map(fn($p) => self::from_array($p), $result);
  }

  public static function from_array(array $post): PostModel
  {
    return new PostModel(
      $post["id"],
      $post["owner_id"] ?? null,
      $post["owner_name"] ?? null,
      $post["root_id"] ?? null,
      $post["reply_id"] ?? null,
      $post["title"],
      $post["content"] ?? null,
      new DateTime($post["created_at"])
    );
  }

  public function get_ftime()
  {
    return $this->created_at->format("m/d/Y H:i");
  }
}
