<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$sql = 'SELECT * FROM `categories`';

if ($res = mysqli_query($link, $sql)) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $content = include_template('error.php', ['error' => mysqli_error($link)]);
}

$lots = [];

$search = $_GET['search'] ?? '';

if ($search) {
    $sql = "
            SELECT * FROM `lots` l
            LEFT JOIN `categories` c ON l.`category_id` = c.`id`
            WHERE  MATCH(title, description) AGAINST(?)
            ";

    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$content = include_template('search_main.php', ['lots' => $lots]);

print include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]);
