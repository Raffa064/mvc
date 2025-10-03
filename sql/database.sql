create database if not exists mvc;

use mvc;

create table if not exists users(
  id int primary key auto_increment,
  name varchar(32) not null,
  email varchar(256) unique not null,
  password varchar(32) not null
);

INSERT INTO users(name, email, password) VALUES ("root", "testing@test.com", 12345678);
