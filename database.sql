CREATE DATABASE IF NOT EXISTS testInlane;

USE testInlane;

CREATE TABLE posts(
    id int NOT NULL,
    userId int NOT NULL,
    title varchar(100),
    body varchar(1000),
    PRIMARY KEY (id)
);

CREATE TABLE comments(
    id int NOT NULL,
    postId int NOT NULL,
    name varchar(100),
    email varchar(100),
    body varchar(1000),
    PRIMARY KEY (id),
    FOREIGN KEY (postId) REFERENCES posts(id)
);