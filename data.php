<?php
session_start();
$is_auth = isset($_SESSION['user']);
$user_name = ($is_auth) ? $_SESSION['user']['name'] : '';

$userId = ($is_auth) ? $_SESSION['user']['id'] : '';


// добавляет категории

$categories = [];
$con = mysqli_connect("localhost", "root", "", "randall_625979_yeticave");
if(!$con) {
    die ('Ошибка подключения');
}
mysqli_set_charset($con, "utf8");

$sql_get_cats = 'SELECT * FROM categories;';
$cat_result = mysqli_query($con, $sql_get_cats);

if ($cat_result) {
    $categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);
}
?>