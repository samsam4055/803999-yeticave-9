CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE  utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128) UNIQUE,
	code CHAR(64) UNIQUE
);

INSERT INTO categories
(name, code) VALUES ('Доски и лыжи', 'skiing'), ('Крепления', 'mounts'), ('Ботинки', 'boots'), ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

CREATE TABLE users (
   id INT AUTO_INCREMENT PRIMARY KEY,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   email CHAR(128) UNIQUE NOT NULL,
   name CHAR NOT NULL,
   password CHAR(64) NOT NULL,
   contact CHAR(128) NOT NULL,
   avatar CHAR(128)
);

CREATE TABLE lots (
	id INT AUTO_INCREMENT PRIMARY KEY,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name CHAR(128) NOT NULL,
	description MEDIUMTEXT NOT NULL,
	img CHAR(128) NOT NULL,
	start_price FLOAT NOT NULL,
	end_at DATETIME NOT NULL,
	rate_step INT NOT NULL,
	user_id INT NOT NULL,
	winner_id INT,
	category_id INT NOT NULL,
	FOREIGN KEY (user_id)  REFERENCES users (id),
	FOREIGN KEY (category_id)  REFERENCES categories (id)
);

CREATE TABLE rates (
	id INT AUTO_INCREMENT PRIMARY KEY,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	amount FLOAT NOT NULL,
	user_id INT NOT NULL,
	lot_id INT NOT NULL,
	FOREIGN KEY (user_id)  REFERENCES users (id)
);
