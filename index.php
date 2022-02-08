<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

    $sql = 'SELECT * FROM `categories`';

    if ($res = mysqli_query($link, $sql)) {
        $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $sql = 'SELECT l.image, l.title, l.id, l.cost, l.dt_add, l.dt_end, c.name, c.id FROM lots l
                JOIN categories c ON l.category_id = c.id
                ORDER BY l.dt_add DESC LIMIT 6';

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
