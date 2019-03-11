<?php
require_once('data.php');
require_once('functions.php');
$title = 'Регистрация';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $form = $_POST;
  $errors = [];

  $req_fields = ['email', 'password', 'name', 'message'];

  foreach ($req_fields as $field) {
    if (empty($form[$field])) {
      $errors[$field] = "Это поле надо заполнить";
      continue;
    }
  }
  
  if(!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Введите корректный E-mail';
  }

  if(empty($errors) && isset($_FILES['image']['name']) && $_FILES['image']['name']) {
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

  if (empty($errors)) {
    if (!empty($_FILES['image']['name'])) {
      $is_uploaded = move_uploaded_file($tmp_name, 'img/avatars/' . $image_path);
    }
    if (!$is_uploaded) {
      $errors['image'] = 'Произошла ошибка загрузки файла';
    }
    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
      $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    }
    else {
      $password = password_hash($form['password'], PASSWORD_DEFAULT);

      $sql = 'INSERT INTO users (
        dt_add,
        email,
        name,
        password,
        contact,
        avatar_path
        )
        VALUES (NOW(), ?, ?, ?, ?, ?)';

      $stmt = db_get_prepare_stmt($con, $sql, [
        $form['email'],
        $form['name'],
        $password,
        $form['message'],
        '/img/avatars/' . $image_path
      ]);

      $res = mysqli_stmt_execute($stmt);
    }

    if ($res && empty($errors)) {
      header("Location: login.php");
      exit();
    }

  }

}

$content = include_template('reg-temp.php', [
  'errors' => $errors,
  'form' => $form,
  'categories' => $categories
]);

$layout = include_template('layout.php', [
  'content' => $content,
  'categories' => $categories,
  'title' => $title
]);

print($layout);
?>