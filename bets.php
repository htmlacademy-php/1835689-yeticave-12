<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$sql = 'SELECT * FROM `categories`';

if ($res = mysqli_query($link, $sql)) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $id = intval($_GET['user_id']);
    if ($_GET['user_id'] === $_SESSION['user']['id']) {

    $sql = "
            SELECT * FROM `rates` r
            JOIN `lots` l ON r.`lot_id` = l.`id`
            JOIN `categories` c ON l.`category_id` = c.`id`
            WHERE r.`user_id` = ${id}
            ORDER BY r.`dt_add` DESC
        ";

    if ($res = mysqli_query($link, $sql)) {
        $bets = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

        $content = include_template('my_bets.php', ['categories' => $categories, 'bets' => $bets]);
    } else {
        $content = include_template('error.php', ['error' => mysqli_error($link)]);
    }
}

print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]));
