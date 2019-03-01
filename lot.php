<?php
require_once('functions.php');
require_once('data.php');

$is_content = false;

if (isset($_GET['id'])) {
    $lot_id = intval($_GET['id']);

    $sql_one_lot = "SELECT l.id, l.name, l.description, l.start_price, l.image_path, COALESCE(MAX(b.bid), l.start_price) AS price, c.name AS cat_name, l.bid_incr
    FROM lots l 
    LEFT JOIN categories c ON l.category_id = c.id
    LEFT JOIN bids b ON b.lot_id = l.id
    WHERE l.dt_end > NOW()
    AND l.id = '$lot_id'
    GROUP BY l.id;";
    $lot_result = mysqli_query($con, $sql_one_lot);
    $lot = mysqli_fetch_assoc($lot_result);


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

        $content = include_template('lot-temp.php', [
            'categories' => $categories,
            'user_name' => $user_name,
            'is_auth' => $is_auth,
            'lot' => $lot,
            'bids' => $bids
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