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

function calc_time ($dt_end) {
    date_default_timezone_set("Europe/Moscow");
    $secs_to_end = strtotime($dt_end) - time();
    if ($secs_to_end <= 0) {
      return '00:00';
      }
    $hours = floor($secs_to_end / 3600);
    $minutes = floor(($secs_to_end % 3600) / 60);
    if ($minutes < 10) {
      $time_to_end = $hours . ':' . 0 . $minutes;
    } else {
       $time_to_end = $hours . ':' . $minutes;
    }

    return $time_to_end;
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

/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param string $date строка с датой
 * @return bool
 */
function check_date_format($date) {
    $result = false;
    $regexp = '/(\d{4})\-(\d{2})\-(\d{2})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[3], $parts[1]);
    }
    return $result;
}
?>