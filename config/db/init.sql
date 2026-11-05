DROP DATABASE IF EXISTS db_panini;

CREATE DATABASE db_panini;
USE db_panini;

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE albums (
    album_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    year INT
);

CREATE TABLE cards (
    card_id INT PRIMARY KEY AUTO_INCREMENT,
    album_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    number INT,
    FOREIGN KEY (album_id) REFERENCES albums(album_id) ON DELETE CASCADE
);

CREATE TABLE packs (
    pack_id INT PRIMARY KEY AUTO_INCREMENT,
    album_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    number_of_cards INT NOT NULL,
    FOREIGN KEY (album_id) REFERENCES albums(album_id) ON DELETE CASCADE
);

CREATE TABLE user_collections (
    collection_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    album_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (album_id) REFERENCES albums(album_id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, album_id)
);