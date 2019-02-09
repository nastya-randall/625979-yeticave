<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

function format_cost ($cost) {
    $int_num = ceil($cost);
    if ($int_num < 1000) {
        $final_cost = $int_num;
    }
    else {
        $final_cost = number_format($int_num, 0, '.', ' ');
    }
    $final_cost = $final_cost . ' ' . '₽';
    return $final_cost;
};
?>