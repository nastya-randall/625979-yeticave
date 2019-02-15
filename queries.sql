/* Создаёт список категорий */

INSERT INTO categories (name) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

/* Добавляет пользователей */

INSERT INTO users SET email = "anastassiya.sviridova@gmail.com", name = "Настя", dt_add = NOW(), password = "12345", contact = "г. Мюнхен";
INSERT INTO users SET email = "ivan.example@gmail.com", name = "Иван", dt_add = NOW(), password = "54321", contact = "г. Санкт-Петербург";

/* Добавляет лоты */

INSERT INTO lots (user_id, category_id, name, start_price, image_path, dt_add, dt_end)
  VALUES
    (1, 1, "2014 Rossignol District Snowboard", 10999, "img/lot-1.jpg", '2019-02-07 15:18:25', '2019-02-17'),
    (2, 1, "DC Ply Mens 2016/2017 Snowboard", 159999, "img/lot-2.jpg", '2019-02-08 16:19:25', '2019-02-18'),
    (1, 2, "Крепления Union Contact Pro 2015 года размер L/XL", 8000, "img/lot-3.jpg", '2019-02-09 17:09:25', '2019-02-19'),
    (2, 3, "Ботинки для сноуборда DC Mutiny Charocal", 10999, "img/lot-4.jpg", '2019-02-09 06:13:25', '2019-02-19'),
    (1, 4, "Куртка для сноуборда DC Mutiny Charocal", 7500, "img/lot-5.jpg", '2019-02-10 11:33:25', '2019-02-20'),
    (2, 6, "Маска Oakley Canopy", 5400, "img/lot-6.jpg", '2019-02-11 21:07:25', '2019-02-21');

/* Добавляет ставки для объявления */

INSERT INTO bids (user_id, lot_id, bid, dt_add)
  VALUES
    (1, 2, 160099, '2019-02-08 19:19:25'),
    (2, 2, 160599, '2019-02-09 07:10:25');

/* получить все категории */

SELECT * FROM categories ORDER BY id ASC;

/* получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории */

SELECT l.name, start_price, image_path, COALESCE(MAX(bid), start_price) AS price, c.name
  FROM lots l
  JOIN categories c ON l.category_id = c.id
  JOIN bids b ON b.lot_id = l.id
  WHERE dt_end > NOW()
  ORDER BY l.dt_add DESC;

/* показать лот по его id. Получите также название категории, к которой принадлежит лот */

SELECT * FROM lots l
  JOIN categories c ON l.category_id = c.id
  WHERE l.id = 4;

/* обновить название лота по его идентификатору */

UPDATE lots SET name = "Крепления Union Contact Pro 2015 года размер S/M"
  WHERE id = 3;

/* получить список самых свежих ставок для лота по его идентификатору */

SELECT * FROM bids
  WHERE lot_id = 2
  ORDER BY dt_add DESC;
