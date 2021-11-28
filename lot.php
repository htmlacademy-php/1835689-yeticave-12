<?php

require_once('helpers.php');
require_once('functions.php');

$link = mysqli_connect("1835689-yeticave-12", "root", "", "yetycave");
mysqli_set_charset($link, "utf8");

if(!$link) {
   $error = mysqli_connect_error();
   $content = include_template('error.php', ['error' => $error]);
}
else {
    $sql = 'SELECT * FROM categories';

    if ($res = mysqli_query($link, $sql)) {
        $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);

        if (isset($_GET['lot_id'])) {
            $id = intval($_GET['lot_id']);
            $sql = 'SELECT * FROM lots WHERE id = ' . $id;
            $res = mysqli_query($link, $sql);
            $lot = mysqli_fetch_assoc($res);
            $content = include_template('lot-main.php', ['categories' => $categories, 'lot' => $lot]);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
        }
    } else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }
}

print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]));
