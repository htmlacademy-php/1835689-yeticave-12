<?php

//session_start();
require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$sql = 'SELECT * FROM `categories`';

if ($res = mysqli_query($link, $sql)) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $content = include_template('error.php', ['error' => mysqli_error($link)]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required_fields = ['email', 'password'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Это поле надо заполнить";
        }
    }

    $email = mysqli_real_escape_string($link, $form['email']);
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$res = mysqli_query($link, $sql);

	$user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

	if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
			$_SESSION['user'] = $user;
		} else {
            $errors['password'] = 'Вы ввели неверный пароль';
        }
	} else {
		$errors['email'] = 'Такой пользователь не найден';
	}

    if (count($errors)) {
		$content = include_template('login.php', ['form' => $form, 'errors' => $errors]);
	} else {
		header("Location: /index.php");
		exit();
    }
} else {
    $content = include_template('login.php', []);

    if (isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit();
    }
}

print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories, 'title' => 'Вход']));
