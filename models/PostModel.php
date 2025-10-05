<?php

class PostModel
{
  public int $id;
  public ?int $owner_id;   // A user could be deleted, and their posts remains
  public ?int $root_id;    // When it's set, it means that the post is a comment 
  public ?int $reply_id;   // If set, the post is an reply to another comment
  public string $title;
  public string $content;

  public static int $CONTENT_MIN_LENGTH = 100;

  public function _construct($id, $owner_id, $root_id, $reply_id, $title, $content)
  {
    $this->id = $id;
    $this->owner_id = $owner_id;
    $this->root_id = $root_id;
    $this->reply_id = $reply_id;
    $this->title = $title;
    $this->content = $content;
  }

  public function is_comment(): bool
  {
    return !is_null($this->root_id);
  }

  public function is_reply(): bool
  {
    return $this->is_comment() && !is_null($this->reply_id);
  }


  public static function create(?int $owner_id, ?int $root_id, ?int $reply_id, string $title, string $content, ?string &$err_msg, ?PostModel &$post): bool
  {
    $err_msg = null;
    $post = null;

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

    $sql = "INSERT INTO posts(owner_id, root_id, reply_id, title, content) VALUES (?, ?, ?, ?, ?);";
    $result = DatabaseModel::query($sql, [$owner_id, $root_id, $reply_id, $title, $content]);

    if ($result === false) {
      $err_msg = "Could not post.";
      return false;
    }

    $post = new PostModel(
      DatabaseModel::last_insert_id(),
      $owner_id,
      $root_id,
      $reply_id,
      $title,
      $content
    );

    return true;
  }

  public static function create_post($owner_id, string $title, string $content, ?string &$err_msg, ?PostModel &$post): bool
  {
    return self::create($owner_id, null, null, $title, $content, $err_msg, $post);
  }

  public static function list_recent(): array|false
  {
    $sql = "SELECT * FROM post_view ORDER BY id DESC LIMIT 100;";
    $result = DatabaseModel::query($sql, []);

    return $result;
  }

  public static function get_by_id(int $id): array|false
  {
    $sql = "SELECT * FROM post_content_view WHERE id = ?;";
    $result = DatabaseModel::query($sql, [$id]);

    if ($result === false || count($result) != 1)
      return false;

    return $result[0];
  }
}
