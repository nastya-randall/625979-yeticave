<?php
require_once('functions.php');
require_once('data.php');
$title = 'Главная';

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


$content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => $title,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout);
?>