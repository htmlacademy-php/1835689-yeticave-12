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

$tpl_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $errors = [];

    $required_fields = ['email', 'password', 'name', 'message'];

    foreach ($required_fields as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Не заполнено поле " . $field;
        }
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "
                SELECT u.`id` FROM `users` u
                WHERE u.`email` = '$email'
                ";
        $res = mysqli_query($link, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $hash = password_hash($form['password'], PASSWORD_BCRYPT);

            $sql = "INSERT INTO `users` (`dt_add`, `email`, `password`, `name`, `telephone`)
                    VALUES (NOW(), ?, ?, ?, ?)";
            $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $hash, $form['name'], $form['message']]);
            $res = mysqli_stmt_execute($stmt);
        }

        if ($res && empty($errors)) {
            $user_id = mysqli_insert_id($link);

            header("Location: /enter.php");
            exit();
        }
    }

    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;
}

$content = include_template('reg.php', $tpl_data);

print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories, 'title' => 'Регистрация']));
