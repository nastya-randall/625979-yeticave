CREATE DATABASE randall_625979_yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE randall_625979_yeticave;

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
    dt_end TIMESTAMP
);

CREATE TABLE bids (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    lot_id INT NOT NULL,
    bid INT NOT NULL,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE UNIQUE INDEX u_email ON users(email);
CREATE INDEX l_cat_id ON lots(category_id);
CREATE INDEX l_user_id ON lots(user_id);
CREATE INDEX b_user_id ON bids(user_id);
CREATE INDEX b_lot_id ON bids(lot_id);
