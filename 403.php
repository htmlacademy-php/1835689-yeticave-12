<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$sql = 'SELECT * FROM `categories`';

if ($res = mysqli_query($link, $sql)) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $content = include_template('error_403.php');
} else {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
}

print(include_template('layout_error.php', ['content' => $content, 'categories' => $categories]));
