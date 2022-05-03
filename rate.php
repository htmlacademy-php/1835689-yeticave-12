<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['cost'];
    $errors = [];

    if ($cost_rate) {
        $last_cost = $cost_rate;
    } else {
        $last_cost = $lot['cost'];
    }

    $rules = [
        'cost' => function($value) {
            return validatePositive($value);
        }
    ];

    $rate = filter_input_array(INPUT_POST, ['cost' => FILTER_DEFAULT], true);

    foreach ($rate as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
        if (in_array($key, $required_fields) && empty($value)) {
            $errors[$key] = "Поле $key надо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $content = include_template('lot-main.php', ['cost' => $rate, 'errors' => $errors]);
    } else {
        $sql = "INSERT INTO `rates` (`dt_add`, `cost_rate`, `user_id`, `Lot_id`)
        VALUES (NOW(), '{$rate['cost']}', {$_SESSION['user']['id']}, ['lot_id'])";

        $res = mysqli_query($link, $sql);
        if ($res) {
            $rate_id = mysqli_insert_id($link);

            header("Location: /lot.php");
        }
    }
} else {
    $content = include_template('lot-main.php');
}
