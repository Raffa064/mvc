CREATE DATABASE IF NOT EXISTS mvc;

USE mvc;

CREATE TABLE IF NOT EXISTS users(
  id int primary key auto_increment,
  name varchar(32) not null,
  email varchar(256) unique not null,
  password varchar(32) not null
);

CREATE TABLE IF NOT EXISTS posts(
  id int primary key auto_increment,
  owner_id int NULL,
  root_id int NULL,
  reply_id int NULL,
  title VARCHAR(256) NOT NULL,
  content TEXT NOT NULL,

  CONSTRAINT owner_id_fk 
    FOREIGN KEY (owner_id)
    REFERENCES users(id)
      ON DELETE SET NULL
      ON UPDATE CASCADE,

  CONSTRAINT root_id_fk
    FOREIGN KEY (root_id)
    REFERENCES posts(id)
      ON DELETE CASCADE
      ON UPDATE CASCADE,

  CONSTRAINT reply_id_fk
    FOREIGN KEY (reply_id)
    REFERENCES posts(id)
      ON DELETE SET NULL
      ON UPDATE CASCADE
);

INSERT INTO users(name, email, password) VALUES ("root", "test@test.com", 12345678);

CREATE VIEW post_view AS
  SELECT
    _post.id,
    _post.title,
    _post.owner_id,
    _user.name AS owner_name
  FROM posts _post 
  LEFT JOIN users _user ON _user.id = _post.owner_id
  WHERE _post.root_id IS NULL;


CREATE VIEW post_content_view AS
  SELECT
    _post.id,
    _post.title,
    _post.content,
    _post.owner_id,
    _user.name AS owner_name
  FROM posts _post 
  LEFT JOIN users _user ON _user.id = _post.owner_id
  WHERE _post.root_id IS NULL;
