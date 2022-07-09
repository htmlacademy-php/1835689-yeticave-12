<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$sql = 'SELECT * FROM `categories`';

if ($res = mysqli_query($link, $sql)) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
}

$cur_page = $_GET['page'] ?? 1;
$page_items = 9;

$result = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lots");
$items_count = mysqli_fetch_assoc($result)['cnt'];

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;

$pages = range(1, $pages_count);

$id = intval($_GET['category_id']);
$sql = "
            SELECT l.`id`, `image`, `title`, l.`category_id`, `cost`, `dt_add`, `dt_end`, `name` FROM `lots` l
            JOIN `categories` c ON l.`category_id` = c.`id`
            WHERE c.`id` = ${id}
            ORDER BY `dt_add` DESC LIMIT $page_items OFFSET $offset
            ";

if ($res = mysqli_query($link, $sql)) {
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $tpl_data = [
        'lots' => $lots,
        'pages' => $pages,
        'pages_count' => $pages_count,
        'cur_page' => $cur_page
    ];

    $content = include_template('all_lots.php', $tpl_data);
} else {
    $content = include_template('error.php', ['error' => mysqli_error($link)]);
}

print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]));
