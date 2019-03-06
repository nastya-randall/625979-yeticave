<?php
require_once('functions.php');
require_once('data.php');

$is_content = false;

if (isset($_GET['id'])) {
  $lot_id = intval($_GET['id']);

  $sql_one_lot = "SELECT l.id, l.name, l.description, l.start_price, l.image_path, COALESCE(MAX(b.bid), l.start_price) AS price, c.name AS cat_name, l.bid_incr, l.user_id, l.dt_end
  FROM lots l 
  LEFT JOIN categories c ON l.category_id = c.id
  LEFT JOIN bids b ON b.lot_id = l.id
  WHERE l.dt_end > NOW()
  AND l.id = '$lot_id'
  GROUP BY l.id;";
  $lot_result = mysqli_query($con, $sql_one_lot);
  $lot = mysqli_fetch_assoc($lot_result);
  $min_bid = get_min_bid($lot['price'], $lot['bid_incr']);


  if ($lot !== null) {
    // находит ставки к лоту
    $sql_get_bids = "SELECT u.name, b.bid, b.dt_add, b.user_id AS bid_author, l.user_id AS lot_author
    FROM bids b
    LEFT JOIN lots l ON b.lot_id = l.id
    LEFT JOIN users u ON b.user_id = u.id
    WHERE l.id = '$lot_id'
    AND b.user_id != l.user_id
    ORDER BY b.dt_add DESC;";
    $bids_result = mysqli_query($con, $sql_get_bids);
    $bids = mysqli_fetch_all($bids_result, MYSQLI_ASSOC);
    
    //проверяем, доступен ли еще лот для торгов

    $dt_end = strtotime($lot['dt_end']);
    $is_end = ($dt_end <= time()) ? true : false;

    //проверяем, добавлял ли уже юзер ставки к данному лоту

    $sql_check_user = "SELECT count(*) as cnt
      FROM bids
      WHERE lot_id = '$lot_id' AND user_id = '$user_id';";
    $check_res = mysqli_query($con, $sql_check_user);
    $check = mysqli_fetch_all($check_res, MYSQLI_ASSOC);

    //проверяем, скрыта ли форма ставок
      $is_rated = ($check[0]['cnt'] > 0) ? true : false;
      $is_author = ($user_id === $lot['user_id']) ? true : false;
      $is_visible = !$is_rated && !$is_author && is_auth;



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $form = $_POST;
      $errors = [];

      $req_fields = ['cost'];

    if (empty($form['cost'])) {
      $errors['cost'] = "Введите вашу ставку";
    }

    if ($form['cost'] < $min_bid && $form['cost'] > 0) {
      $errors['cost'] = "Введите сумму не меньше " . $min_bid . "₽";
    }

    if (empty($errors)) {
      if ($user_id !== $lot['user_id']) {
        $sql_add_bid = 'INSERT INTO bids (
        user_id,
        lot_id,
        bid,
        dt_add
        )
        VALUES (?, ?, ?, NOW())';


      $stmt = db_get_prepare_stmt($con, $sql_add_bid, [
        $user_id,
        $lot_id,
        $form['cost']
      ]);

      $res = mysqli_stmt_execute($stmt);
      if ($res) {
        header("Location: lot.php?id=" . $lot['id']);
      }

      } else {
        $errors['cost'] = "Автор лота не может добавлять к нему ставки";
      }
    }
    }

    $content = include_template('lot-temp.php', [
      'categories' => $categories,
      'user_name' => $user_name,
      'is_auth' => $is_auth,
      'lot' => $lot,
      'bids' => $bids,
      'min_bid' => $min_bid,
      'errors' => $errors,
      'form' => $form,
      'is_visible' => $is_visible
    ]);
    $title = $lot['name'];
    $is_content = true;

  }
}

if (!$is_content) {
    $title = '404 Страница не найдена';
    $message = 'Данной страницы не существует на сайте.';
    $content = include_template('error.php', [
            'categories' => $categories,
            'user_name' => $user_name,
            'is_auth' => $is_auth,
            'message' => $message,
            'title' => $title
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