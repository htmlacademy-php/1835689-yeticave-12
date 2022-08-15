<?php

require_once('helpers.php');
require_once('functions.php');
require_once('connect.php');

$sql = 'SELECT * FROM `categories`';

$category_ids = [];

if ($res = mysqli_query($link, $sql)) {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $category_ids = array_column($categories, 'id');
} else {
    $content = include_template('error.php', ['error' => mysqli_error($link)]);
}

if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required_fields = ['category', 'lot-name', 'message', 'lot-rate', 'lot-step', 'lot-date'];
        $errors = [];

        $rules = [
            'category' => function ($value) use ($category_ids)
            {
                return validateCategory($value, $category_ids);
            },
            'lot-rate' => function ($value)
            {
                return validatePositive($value);
            },
            'lot-step' => function ($value)
            {
                return validatePositive($value);
            },
            'lot-date' => function ($value)
            {
                if (is_date_valid($value) === false) {
                    return "Введите дату в формате ГГГГ-ММ-ДД";
                }
            }
        ];

        $lot = filter_input_array(INPUT_POST, ['category' => FILTER_DEFAULT, 'lot-name' => FILTER_DEFAULT, 'message' => FILTER_DEFAULT, 'lot-rate' => FILTER_DEFAULT, 'lot-date' => FILTER_DEFAULT, 'lot-step' => FILTER_DEFAULT], true);

        foreach ($lot as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule($value);
            }
            if (in_array($key, $required_fields) && empty($value)) {
                $errors[$key] = "Поле $key надо заполнить";
            }
        }

        $errors = array_filter($errors);

        if (!empty($_FILES['lot_img']['name'])) {
            $tmp_name = $_FILES['lot_img']['tmp_name'];
            $image = $_FILES['lot_img']['name'];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);

            if ($file_type === "image/jpeg") {
                $ext = ".jpg";
            } else if ($file_type === "image/png") {
                $ext = ".png";
            }

            $filename = uniqid() . $ext;

            if ($file_type !== $ext) {
                $errors['image'] = "Загрузите файл в формате JPEG или PNG";
            } else {
                move_uploaded_file($tmp_name, 'uploads/' . $filename);
                $lot['image'] = 'uploads/' . $filename;
            }
        } else {
            $errors['image'] = "Вы не загрузили файл";
        }

        if (count($errors)) {
            $content = include_template('add-main.php', ['lot' => $lot, 'errors' => $errors, 'categories' => $categories]);
        } else {
            $sql = "
                INSERT INTO `lots` (`dt_add`, `category_id`, `user_id`, `title`, `description`, `image`, `cost`, `dt_end`, `step`)
                VALUES (NOW(), ?, {$_SESSION['user']['id']}, ?, ?, ?, ?, ?, ?)
                ";
            $stmt = db_get_prepare_stmt($link, $sql, [$lot['category'], $lot['lot-name'], $lot['message'], $lot['image'], $lot['lot-rate'], $lot['lot-date'], $lot['lot-step']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                $lot_id = mysqli_insert_id($link);

                header("Location: /lot.php?lot_id=" . $lot_id);
            }
        }
    } else {
        $content = include_template('add-main.php', ['categories' => $categories]);
    }
} else {
    $content = include_template('error_403.php', ['error' => mysqli_error($link)]);
    print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]));
    exit();
}

print(include_template('layout-inner.php', ['content' => $content, 'categories' => $categories]));
