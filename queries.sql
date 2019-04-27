
INSERT INTO categories
(name, code) VALUES ('Доски и лыжи', 'skiing'), ('Крепления', 'mounts'), ('Ботинки', 'boots'), ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

INSERT INTO users
(email, name, password, contact, avatar) VALUES ('a1@mail.ua', 'Вася', 'pass1', 'улица Пушкина', 'img/ava1.jpg'), ('a2@mail.ua', 'Петя', 'pass2', 'улица Шевченко', 'img/ava2.jpg');

INSERT INTO lots
(name, description, img, start_price, end_at, rate_step, user_id, category_id) VALUES 
	('2014 Rossignol District Snowboard', 'Описание лота 1', 'img/lot-1.jpg', '10999', '2019-04-20', '100', '1', '1'),
	('DC Ply Mens 2016/2017 Snowboard', 'Описание лота 2', 'img/lot-2.jpg', '159999', '2019-04-21', '100', '2', '1'),
	('Крепления Union Contact Pro 2015 года размер L/XL', 'Описание лота 3', 'img/lot-3.jpg', '8000', '2019-04-22', '100', '2', '2'),
	('Ботинки для сноуборда DC Mutiny Charocal', 'Описание лота 4', 'img/lot-4.jpg', '10999', '2019-04-23', '100', '2', '3'),
	('Куртка для сноуборда DC Mutiny Charocal', 'Описание лота 5', 'img/lot-5.jpg', '7500', '2019-04-21', '100', '1', '4'),
	('Маска Oakley Canopy', 'Описание лота 6', 'img/lot-6.jpg', '5400', '2019-04-22', '100', '1', '6')
