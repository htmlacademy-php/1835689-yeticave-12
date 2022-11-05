<?php

/**
 * Округляет переданное число и разделяет разряды
 *
 * @param float $form_cost - число, которое надо округлить и разделить на разряды, чтобы имело красивый вид на сайте
 *
 * @return string - отформатированное число
 */

function formate_cost($form_cost)
{
    $form_cost = ceil($form_cost);
    $form_cost = ($form_cost < 1000) ? $form_cost : number_format($form_cost, 0, '', ' ');
    return $form_cost . ' ' . '&#8381';
}

/** Возвращает разницу между текущей датой и переданной датой
 *
 * @param string $date - дата в фомате 'ГГГГ-ММ-ДД' истечения времени
 *
 * @return string - разница между сегодняшней датой и заданной дататой в формате 'ЧЧ:ММ'
*/

function get_dt_range($date)
{
    date_default_timezone_set('Eroupe/Moscow');
    $final_date = date_create($date);
    $cur_date = date_create('now');
    $diff = date_diff($final_date, $cur_date);
    $format_diff = date_interval_format($diff, "%d %H %I");
    $arr = explode(" ", $format_diff);

    $hours = $arr[0] * 24 + $arr[1];
    $minuts = intval($arr[2]);
    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minuts = str_pad($minuts, 2, "0", STR_PAD_LEFT);
    $res[] = $hours;
    $res[] = $minuts;

    return $res;
}

/** Проверяет в форме данные поля "Категория" на существование в заданном списке
 *
 * @param array $id, $allowed_list - номер и название категории
 *
 * @return null
 */

function validateCategory($id, $allowed_list)
{
    if (!in_array($id, $allowed_list)) {
        return "Указана не существующая категория";
    }
    return null;
}

/**  Проверяет число на положительное
 *
 * @param number $value - введенное число
 *
 * @return null
*/

function validatePositive($value)
{
    if ($value <= 0) {
        return "Введите положительное число";
    }
    return null;
}

/** Проверяет дату окончания лота, чтобы она была не менее суток
 *
 * @param string $date - дата введенная в поле окончания лота
 *
 * @return string - смотрит разницу между текущей датой и введенной датой и возвращает ошибку, если она меньше суток
 */

function validateDate($date)
{
    $cur_date = date_create('now');
    $date = date_create($date);
    $diff = date_diff($cur_date, $date);
    if ($diff->h < 24) {
        return "Дата должна быть больше хотя бы на сутки";
    }
}

/** Фильтрует и сохраняет значение из формы
 *
 * @param string $name - введенное значение в форму
 *
 * @return string - Возвращает отфильтрованное значение
 */

function getPostVal($name)
{
    return filter_input(INPUT_POST, $name);
}

/** Возвращает разницу между текущей датой и переданной датой в минутах
 *
 * @param string $date - дата в фомате 'ГГГГ-ММ-ДД' истечения времени
 *
 * @return string - разница между сегодняшней датой и заданной дататой в минутах
*/

function diffDate($date)
{
    date_default_timezone_set('Eroupe/Moscow');
    $final_date = date_create($date);
    $cur_date = date_create('now');
    $diff = date_diff($final_date, $cur_date);
    $format_diff = date_interval_format($diff, "%d %H %I");
    $arr = explode(" ", $format_diff);

    $minutes = intval($arr[0] * 1440 + $arr[1] * 60 + $arr[2]);

    return $minutes;
}

/**
 * Записывает в таблицу лотов в базе данных ID победителя торгов по конкретному лоту
 *
 * @param $con - Подключение к MySQL
 * @param $winer_id - ID победителя торгов
 * @param $lot_id - ID лота
 *
 * @return [Bool | String] $res - Возвращает true в случае успешной записи или описание последней ошибки подключения
 */

function add_winner ($con, $winer_id, $lot_id) {
    if (!$con) {
    $error = mysqli_connect_error();
    return $error;
    } else {
        $sql = "
        UPDATE lots SET winner_id = $winer_id WHERE id = $lot_id
        ";
        $result = mysqli_query($con, $sql);
        if ($result) {
            return $result;
        }
            $error = mysqli_error($con);
            return $error;
    }
}

/**
 * Возвращает имя пользователя и название лота для письма
 *
 * @param $con - Подключение к MySQL
 * @param $id - ID лота
 *
 * @return [Array | String] $data - массив или описание последней ошибки подключения
 */

function get_user_win ($con, $id) {
    if (!$con) {
    $error = mysqli_connect_error();
    return $error;
    } else {
        $sql = "
        SELECT l.`id`, l.`title`, u.`name`, u.`telephone` FROM `rates` r
        JOIN `lots` l ON r.`lot_id` = l.`id`
        JOIN `users` u ON r.`user_id` = u.`id`
        WHERE l.`id` = $id
        ";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $data = get_arrow($result);
            return $data;
        }
        $error = mysqli_error($con);
        return $error;
    }
}

/**
 * Возвращает email, телефон и имя пользователя по id
 *
 * @param $con - Подключение к MySQL
 * @param $id - ID пользователя
 *
 * @return [Array | String] $user_date - массив или описание последней ошибки подключения
 */

function get_user_contacts ($con, $id) {
    if (!$con) {
    $error = mysqli_connect_error();
    return $error;
    } else {
        $sql = "
        SELECT u.`name`, u.`email`, u.`telephone` FROM `users` u
        WHERE `id` = $id
        ";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $user_date = get_arrow($result);
            return $user_date;
        }
        $error = mysqli_error($con);
        return $error;
    }
}

/**
 * Возвращает массив из объекта результата запроса
 *
 * @param object $result_query mysqli - Результат запроса к базе данных
 *
 * @return array
 */

function get_arrow ($result_query) {
    $row = mysqli_num_rows($result_query);
    if ($row === 1) {
        $arrow = mysqli_fetch_assoc($result_query);
    } else if ($row > 1) {
        $arrow = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
    }

    return $arrow;
}

?>
