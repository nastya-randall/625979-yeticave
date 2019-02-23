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
    $keys = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $lot = $_POST;

//    $required = [
//      'lot-name',
//      'category',
//      'message',
//      'image',
//      'lot-rate',
//      'lot-step',
//      'lot-date'];
    $errors = [];
    foreach ($lot as $key => $value) {
      if (empty($lot[$key])) {
        $errors[$key] = 'Это поле надо заполнить';
      }

      if($key === 'category' && $value === 'Выберите категорию') {
            $errors[$key] = 'Выберите категорию';
        }
    }

    if(isset($_FILES['image'])) {
      $file_name = $_FILES['image']['name'];
      $file_path = __DIR__ . '/img/';

      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $file_type = finfo_file($finfo, $file_name);
      if ($file_type !== "image/jpeg" || "image/png") {
        $errors['file'] = 'Загрузите изображение  в формате JPEG или PNG';
      }
      else {
        move_uploaded_file($_FILES['image']['tmp_name'], $file_path . $file_name);
      }
    }
      else {
      $errors['file'] = 'Загрузите изображение';
      }

      if (count($errors)) {
        $page_content = include_template('add-temp.php', [
          'lot' => $lot,
          'errors' => $errors, 'dict' => $dict]);
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
    $lot_id = mysqli_insert_id($con);

    header('Location: lot.php?id=' . $lot_id);
  }
  else {
    $content = include_template('error.php', [
      'error' => mysqli_error($con)
    ]);
  }
  }

  else {
    $layout = include_template('layout.php', [
      'content' => $content,
      'categories' => $categories,
      'title' => $title,
      'user_name' => $user_name,
      'is_auth' => $is_auth
    ]);

    print($layout);
  }
}

?>