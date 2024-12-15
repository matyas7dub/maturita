CREATE DATABASE IF NOT EXISTS flappy_bird;
USE flappy_bird;


CREATE TABLE IF NOT EXISTS users (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(15) NOT NULL UNIQUE,
    password char(64) NOT NULL,
    email varchar(30) NOT NULL UNIQUE,
    verified ENUM("yes", "no") DEFAULT "no"
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS scores (
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    score int NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (user_id)
                       REFERENCES users(id)
) ENGINE = INNODB;
