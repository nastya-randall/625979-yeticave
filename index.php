<?php
require_once('functions.php');
require_once('data.php');

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