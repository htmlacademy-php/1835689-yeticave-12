CREATE DATEBASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci

USE yeticave

CREATE TABLE categories (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name CHAR(15) NOT NULL,
    code CHAR(15) NOT NULL
);

CREATE TABLE lots (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    category_id INT(11) UNSIGNED NOT NULL,
    user_id INT(11) UNSIGNED NOT NULL,
    title CHAR(70) NOT NULL,
    description TEXT NOT NULL,
    image CHAR(128) NOT NULL,
    cost DECIMAL NOT NULL,
    dt_end DATETIME NOT NULL,
    step INT(5) UNSIGNED NOT NULL
);

CREATE TABLE users (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    email CHAR(60) NOT NULL UNIQUE,
    name CHAR(100) NOT NULL,
    password CHAR(32) NOT NULL UNIQUE,
    telephone VARCHAR(25) NOT NULL
);

CREATE TABLE rates (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cost_rate INT(11) UNSIGNED NOT NULL,
    user_id INT(11) UNSIGNED NOT NULL,
    lot_id INT(11) UNSIGNED NOT NULL
);

CREATE TABLE winners (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lot_id INT(11) UNSIGNED NOT NULL,
    user_id INT(11) UNSIGNED NOT NULL
);
