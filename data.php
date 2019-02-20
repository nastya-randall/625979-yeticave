<?php
$title = 'Главная';
$user_name = 'Настя Свиридова';
$is_auth = rand(0, 1);

// добавляет категории

$categories = [];
$con = mysqli_connect("localhost", "root", "", "randall_625979_yeticave");
if(!$con) {
    die ('Ошибка подключения');
}
mysqli_set_charset($con, "utf8");

$sql_get_cats = 'SELECT * FROM categories;';
$cat_result = mysqli_query($con, $sql_get_cats);

if ($cat_result) {
    $categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);
}

// добавляет лоты

$lots = [];
$sql_get_lots = 'SELECT l.id, l.name, l.start_price, l.image_path, COALESCE(MAX(b.bid), l.start_price) AS price, c.name AS cat_name
  FROM lots l
  LEFT JOIN categories c ON l.category_id = c.id
  LEFT JOIN bids b ON b.lot_id = l.id
  WHERE l.dt_end > NOW()
  GROUP BY l.id
  ORDER BY l.dt_add DESC;';

$lots_result = mysqli_query($con, $sql_get_lots);
if ($lots_result) {
    $lots = mysqli_fetch_all($lots_result, MYSQLI_ASSOC);
}
?>