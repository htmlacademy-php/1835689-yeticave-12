<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$id = intval($_GET['lot_id']);

$sql = 'SELECT * FROM `categories`';

if ($res = mysqli_query($link, $sql)) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $sql = "
            SELECT l.`id`, `dt_add`, `category_id`, `title`, `description`, `image`, `cost`, `dt_end`, `step` FROM `lots` l
            JOIN `categories` c ON l.`category_id` = c.`id`
            WHERE l.`id` = $id
        ";

    if ($res = mysqli_query($link, $sql)) {
        $lot = mysqli_fetch_assoc($res);

        if (!$lot) {
            $error = "Нет такого лота";
            $content = include_template('error.php', ['error' => $error]);
        } else {

            $sql = "
                SELECT * FROM `rates` r
                JOIN `users` u ON r.`user_id` = u.`id`
                WHERE r.`lot_id` = $id
                ORDER BY r.`dt_add` DESC LIMIT 10
            ";
            if ($res = mysqli_query($link, $sql)) {
                $rates = mysqli_fetch_all($res, MYSQLI_ASSOC);
            }

            $content = include_template('lot-main.php', ['lot' => $lot, 'rates' => $rates]);
        }
    } else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $field = ['cost'];
        $errors = [];

        $rules = [
            'cost' => function ($value) {
                return validatePositive($value);
            }
        ];

        $bet = filter_input_array(INPUT_POST, ['cost' => FILTER_DEFAULT], true);

        foreach ($bet as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule($value);
            }
            if (in_array($key, $field) && empty($value)) {
                $errors[$key] = "Поле $key надо заполнить";
            }
        }

        $errors = array_filter($errors);

        if (count($errors)) {
            $content = include_template('lot-main.php', ['errors' => $errors]);
        } else {

            mysqli_query($link, "START TRANSACTION");
            $sql1 = "
            UPDATE lots SET cost = $bet[cost] WHERE id = $id
            ";
            $sql2 = "
            INSERT INTO rates (dt_add, cost_rate, user_id, lot_id)
            VALUES (NOW(), {$bet['cost']}, {$_SESSION['user']['id']}, $id)
            ";

            $res1 = mysqli_query($link, $sql1);
            $res2 = mysqli_query($link, $sql2);

            if ($res1 && $res2) {
                mysqli_query($link, "COMMIT");
            } else {
                mysqli_query($link, "ROLLBACK");
            }

            header("Location: /lot.php?lot_id=" . $id);
            exit;
        }
    }
}
print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]));
