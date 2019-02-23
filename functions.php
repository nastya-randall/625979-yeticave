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

function calc_time () {
    date_default_timezone_set("Europe/Moscow");
    $ts_midnight = strtotime('tomorrow');
    $secs_to_midnight = $ts_midnight - time();
    $hours = floor($secs_to_midnight / 3600);
    $minutes = floor(($secs_to_midnight % 3600) / 60);
    $time_to_midnight = $hours . ':' . $minutes;
    return $time_to_midnight;
}


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

function get_min_bid ($cur_price, $bid_incr) {
    $min_bid = $cur_price + $bid_incr;
    return $min_bid;
};


// @return mysqli_stmt Подготовленное выражение

function db_get_prepare_stmt($link, $sql, $data = []) {
  $stmt = mysqli_prepare($link, $sql);

  if ($data) {
      $types = '';
      $stmt_data = [];

      foreach ($data as $value) {
          $type = null;

          if (is_int($value)) {
              $type = 'i';
          }
          else if (is_string($value)) {
              $type = 's';
          }
          else if (is_double($value)) {
              $type = 'd';
          }

          if ($type) {
              $types .= $type;
              $stmt_data[] = $value;
          }
      }

      $values = array_merge([$stmt, $types], $stmt_data);

      $func = 'mysqli_stmt_bind_param';
      $func(...$values);
  }

  return $stmt;
}
?>