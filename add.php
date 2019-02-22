<?php
require_once('functions.php');
require_once('data.php');
$title = 'Добавление лота';

if (!$con) {
  $title = 'Ошибка подлючения';
  $content = include_template('error.php', [
    'title' => $title
  ]);
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