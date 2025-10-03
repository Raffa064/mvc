<?php

enum ERR: int
{
  case BAD_REQUEST = 400;
  case UNAUTHORIZED = 401;
  case FORBIDDEN = 403;
  case NOT_FOUND = 404;
  case METHOD_NOT_ALLOWED = 405;
  case TIMEOUT = 408;
  case CONFLICT = 409;
  case INTERNAL_SERVER_ERROR = 500;
  case NOT_IMPLEMENTED = 501;
}

class ErrorModel
{
  public ERR $err;
  public string $message;

  public function __construct(ERR $err, $message)
  {
    $this->err = $err;
    $this->message = $message;
  }

  public function errcode(): ?string
  {
    return ucwords(str_replace("_", " ", strtolower($this->err->name)));
  }
}
