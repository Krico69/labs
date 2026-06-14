
CREATE DATABASE IF NOT EXISTS users_db
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE users_db;


DROP TABLE IF EXISTS users;

CREATE TABLE users (

    id       INT          NOT NULL AUTO_INCREMENT,

    username VARCHAR(50)  NOT NULL,


    email    VARCHAR(100) NOT NULL,

    password VARCHAR(255) NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_username (username),
    UNIQUE KEY uq_email    (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO users (username, email, password) VALUES
('admin',      'admin@example.com',   '81dc9bdb52d04dc20036dbd8313ed055'),
('ivan',       'ivan@example.com',    '81dc9bdb52d04dc20036dbd8313ed055'),
('olena',      'olena@example.com',   '81dc9bdb52d04dc20036dbd8313ed055');
