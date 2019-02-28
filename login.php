<?php
require_once('data.php');
require_once('functions.php');
$title = 'Вход';


$content = include_template('login-temp.php', [
  'categories' => $categories
]);

$layout = include_template('layout.php', [
  'content' => $content,
  'categories' => $categories,
  'title' => $title
]);

print($layout);
?>