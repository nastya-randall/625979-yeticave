<?php
require_once('functions.php');
require_once('data.php');

$content = include_template('404.php', [
        'categories' => $categories,
        'user_name' => $user_name,
        'is_auth' => $is_auth
]);

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
        $content = include_template('lot-temp.php', [
            'categories' => $categories,
            'user_name' => $user_name,
            'is_auth' => $is_auth,
            'lot' => $lot
        ]);
    }
}

print ($content);
?>