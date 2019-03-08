<?php
require_once('functions.php');
require_once('data.php');
$title = 'Главная';

if(isset($_GET['id'])) {
  $category_id = intval($_GET['id']);

  $lots = [];
  $sql_lots_cat =
  "SELECT
    l.id,
    l.name,
    l.dt_add,
    c.name AS cat_name,
    COALESCE(MAX(b.bid), l.start_price) AS price,
    l.image_path,
    l.dt_end
  FROM lots l
  JOIN categories c ON l.category_id = c.id
  LEFT JOIN bids b ON b.lot_id = l.id
  WHERE dt_end > NOW() AND category_id = '$category_id'
  GROUP BY l.id
  ORDER BY dt_add DESC;";
  
  $lots_res = mysqli_query($con, $sql_lots_cat);

  if($lots_res) {
    $lots = mysqli_fetch_all($lots_res, MYSQLI_ASSOC);
  }
  if(count($lots) > 0) {

    $sql_get_cat = "SELECT name FROM categories WHERE id = $category_id;";
    $cat_result = mysqli_query($con, $sql_get_cat);

    if ($cat_result) {
      $category = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);
      $category_name = $category[0]['name'];
    }


    $content = include_template('all-lots-temp.php', [
        'categories' => $categories,
        'user_name' => $user_name,
        'lots' => $lots,
        'category_name' => $category_name
      ]);
      $title = $category_name;
  } else {
    $title = 'Ничего не найдено';
    $message = 'В данной категории на данный момент нет лотов';
    $content = include_template('error.php', [
            'categories' => $categories,
            'user_name' => $user_name,
            'message' => $message,
            'title' => $title
    ]);
  }
}

$layout = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => $title,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout);

?>