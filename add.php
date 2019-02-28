<?php
require_once('functions.php');
require_once('data.php');
$title = 'Добавление лота';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
  $lot = $_POST;
  $errors = [];

  foreach ($required as $key) {
    if (empty($lot[$key])) {
      $errors[$key] = 'Это поле надо заполнить';
      continue;
    }

    if($key === 'category') {
      $lot[$key] = (int)$lot[$key];
      if ($lot[$key] < 1) {
        $errors[$key] = 'Выберите категорию';
      }
    }
  }

  if(isset($_FILES['image']['name']) && $_FILES['image']['name']) {
    $tmp_name = $_FILES['image']['tmp_name'];
      $image_path = $_FILES['image']['name'];

    if (!empty($_FILES['image']['error'])) {
      $errors['image'] = 'Произошла ошибка загрузки файла. Повторите попытку или загрузите другой файл';
    }
    else {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $file_type = finfo_file($finfo, $tmp_name);

      if ($file_type !== "image/jpeg" && $file_type !== "image/pjpeg" && $file_type !== "image/png" && $file_type !== "image/webp") {
        $errors['image'] = 'Загрузите изображение в формате JPEG или PNG';
      }
    }
  }
  else {
    $errors['image'] = 'Загрузите изображение';
  }

  if (!empty($lot['lot-date'])) {
    $lot_date = $lot['lot-date'];

    if (check_date_format($lot_date) == false) {
      $errors['lot-date'] = 'Укажите дату в формате ДД.ММ.ГГГГ';
    } else {
      $timestamp = strtotime($lot_date);
      if ($timestamp < strtotime('tomorrow')) {
        $errors['lot-date'] = 'Указанная дата должна быть больше текущей даты хотя бы на один день';
      }
    }
  }

  if (!empty($lot['lot-rate'])) {
    $lot_rate = $lot['lot-rate'];
    if (!filter_var($lot_rate, FILTER_VALIDATE_INT)) {
      $errors['lot-rate'] = 'Указанное значение должно быть целым числом';
    } else {
        if ($lot_rate < 0) {
          $errors['lot-rate'] = 'Указанное значение должно быть больше 0';
      }
    }
  }

    if (!empty($lot['lot-step'])) {
    $lot_step = $lot['lot-step'];
    if (!filter_var($lot_step, FILTER_VALIDATE_INT)) {
      $errors['lot-step'] = 'Указанное значение должно быть целым числом';
    }
    if ($lot_step < 0) {
      $errors['lot-step'] = 'Указанное значение должно быть больше 0';
    }
  }

  if (count($errors)) {
    $content = include_template('add-temp.php', [
      'categories' => $categories,
      'lot' => $lot,
      'errors' => $errors
    ]);
  }

      // при отсутствии ошибок перемещаем картинку

  else {
    move_uploaded_file($tmp_name, 'img/' . $image_path);

    // записываем данные из формы в БД

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
      '/img/' . $image_path,
      $lot['lot-rate'],
      $lot['lot-date'],
      $lot['lot-step']
    ]);
    $res = mysqli_stmt_execute($stmt);

    // если запись данных прошла успешно, то мы переадресовываем пользователя

    if ($res) {
      $lot_id = mysqli_insert_id($con);
      header('Location: lot.php?id=' . $lot_id);
    }

    // в противном случае выводится страница ошибки

    else {
    $content = include_template('error.php', [
    'error' => mysqli_error($con)
    ]);
    }

    $content = include_template('add-temp.php', [
      'categories' => $categories,
      'lot' => $lot
    ]);
  }
}

else {
  $content = include_template('add-temp.php', [
    'categories' => $categories
  ]);

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