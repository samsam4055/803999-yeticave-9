
INSERT INTO categories
(id, name, code) VALUES ('1', 'Доски и лыжи', 'boards'), ('2', 'Крепления', 'attachment'), ('3','Ботинки', 'boots'), ('4','Одежда', 'clothing'), ('5', 'Инструменты', 'tools'), ('6', 'Разное', 'other');

INSERT INTO users
(id, email, name, password, contact, avatar_url) VALUES ('1', 'a1@mail.ua', 'Вася', 'pass1', 'улица Пушкина', 'img/ava1.jpg'), ('2', 'a2@mail.ua', 'Петя', 'pass2', 'улица Шевченко', 'img/ava2.jpg');

INSERT INTO lots
(id, name, description, img_url, start_price, end_at, rate_step, user_id, category_id) VALUES
	('1', '2014 Rossignol District Snowboard', 'Описание лота 1', 'img/lot-1.jpg', '10999', '2019-04-29', '100', '1', '1'),
	('2', 'DC Ply Mens 2016/2017 Snowboard', 'Описание лота 2', 'img/lot-2.jpg', '159999', '2019-04-28', '100', '2', '1'),
	('3', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Описание лота 3', 'img/lot-3.jpg', '8000', '2019-04-22', '100', '2', '2'),
	('4', 'Ботинки для сноуборда DC Mutiny Charocal', 'Описание лота 4', 'img/lot-4.jpg', '10999', '2019-04-30', '100', '2', '3'),
	('5','Куртка для сноуборда DC Mutiny Charocal', 'Описание лота 5', 'img/lot-5.jpg', '7500', '2019-04-27', '100', '1', '4'),
	('6','Маска Oakley Canopy', 'Описание лота 6', 'img/lot-6.jpg', '5400', '2019-04-22', '100', '1', '6');

INSERT INTO rates
(id, amount, user_id, lot_id) VALUES ('1', '12000', '1', '1'), ('2', '170000', '2', '2');

/* получить все категории */
SELECT * FROM categories;

/* получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории */
SELECT DISTINCT l.id, l.name AS title, start_price, img_url, c.name AS category, MAX(IF(amount IS NULL, start_price, amount)) AS price
  FROM lots l
  JOIN categories c ON l.category_id = c.id
  LEFT JOIN rates r ON l.id = r.lot_id
  WHERE end_at > CURRENT_TIMESTAMP and winner_id IS NULL
  GROUP BY l.id
  ORDER BY l.id DESC;

/* показать лот по его id и название категории*/
SELECT l.id, l.name, c.name FROM lots AS l
    LEFT JOIN categories AS c ON l.category_id = c.id
    WHERE l.id = 1;

/* обновить название лота по его идентификатору */
UPDATE lots SET  name = 'Другое имя лота'
    WHERE id = 1;

/* получить список самых свежих ставок для лота по его идентификатору */
SELECT id, amount FROM rates
    WHERE lot_id = 2;
