<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

    $sql = 'SELECT * FROM `categories`';

    if ($res = mysqli_query($link, $sql)) {
        $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $sql = 'SELECT * FROM `lots`'
        . 'JOIN `categories` ON `lots`.`category_id` = `categories`.`id`'
        . 'ORDER BY `dt_add` DESC LIMIT 6';

        if ($res = mysqli_query($link, $sql)) {
            $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
        }
    } else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }

print(include_template('layout.php', ['content' => $content, 'categories' => $categories]));
