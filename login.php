<?php
require_once('data.php');
require_once('functions.php');
$title = 'Вход';
$form = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $form = $_POST;
  

  $req_fields = ['email', 'password'];

  foreach ($req_fields as $field) {
    if (empty($form[$field])) {
      $errors[$field] = "Это поле надо заполнить";
      continue;
    }
  }
  
  if(!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Введите корректный E-mail';
  }

  $email = mysqli_real_escape_string($con, $form['email']);
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $res = mysqli_query($con, $sql);

  $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

  if (!count($errors) and $user) {
    if (password_verify($form['password'], $user['password'])) {
      $_SESSION['user'] = $user;
    }
    else {
      $errors['password'] = 'Вы ввели неверный пароль';
    }
  }

  else {
    $errors['email'] = 'Такой пользователь не найден';
  }

  if (empty($errors)) {
    header("Location: index.php");
    exit();
  }
}


$content = include_template('login-temp.php', [
  'categories' => $categories,
  'errors' => $errors,
  'form' => $form
]);

$layout = include_template('layout.php', [
  'content' => $content,
  'categories' => $categories,
  'title' => $title,
  'is_auth' => $is_auth
]);

print($layout);
?>