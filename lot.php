<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$sql = 'SELECT * FROM `categories`';

    if ($res = mysqli_query($link, $sql)) {
        $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $id = intval($_GET['lot_id']);
        $sql = 'SELECT * FROM `lots` WHERE `id` = ' . $id;

        if ($res = mysqli_query($link, $sql)) {
            $lot = mysqli_fetch_assoc($res);
            $content = include_template('lot-main.php', ['lot' => $lot]);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
        }
    } else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }

print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]));
