<?php
require_once('functions.php');
require_once('data.php');
$title = 'Добавление лота';

if (!$con) {
  $title = 'Ошибка';
  $content = include_template('error.php', [
    'error' => mysqli_error($con)
  ]);
}
else {
  $content = include_template('add-temp.php', [
    'categories' => $categories
  ]);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    if(isset($_FILES['image'])) {
      $file_name = $_FILES['image']['name'];
      $file_path = __DIR__ . '/img/';
      move_uploaded_file($_FILES['image']['tmp_name'], $file_path . $file_name);
    }

    $sql_add_lot = 'INSERT INTO lots (
      dt_add,
      category_id,
      user_id,
      name,
      description,
      image_path,
      start_price,
      dt_end,
      bid_incr
    )
    VALUES (NOW(), ?, 1, ?, ?, ?, ?, ?, ?);';

    $stmt = db_get_prepare_stmt($con, $sql_add_lot, [
      $lot['category'],
      $lot['lot-name'],
      $lot['message'],
      '/img/' . $file_name,
      $lot['lot-rate'],
      $lot['lot-date'],
      $lot['lot-step']
    ]);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
      $lot_id = mysqli_insert_id($link);

      header("Location: lot.php?id=" . $lot_id);
    }
    else {
      $content = include_template('error.php', [
        'error' => mysqli_error($con)
      ]);
    }
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