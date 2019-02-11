CREATE DATABASE yeticave;
DEFAULT CHARACTER SET utf8;
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email CHAR(255) NOT NULL UNIQUE,
    password CHAR(64) NOT NULL,
    name CHAR(255) NOT NULL,
    contact TEXT NOT NULL,
    avatar_path CHAR (255),
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(255)
);

INSERT INTO categories (name) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    user_id INT NOT NULL,
    winner_id INT NOT NULL,
    name CHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_path CHAR(255) NOT NULL,
    start_price INT NOT NULL,
    bid_incr INT NOT NULL,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dt_end TIMESTAMP,
);

CREATE TABLE bids (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    lot_id INT NOT NULL,
    bid INT NOT NULL,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

JOIN categories c ON lots.category_id = c.id;
JOIN users u ON lots.user_id = u.id;
JOIN u ON bids.user_id = u.id;
JOIN lots l ON bids.lot_id = l.id;