<?php

/**
 * Округляет переданное число и разделяет разряды
 *
 * @param $form_cost Число, которое надо округлить и разделить на разряды, чтобы имело красивый вид на сайте
 *
 * @return $form_cost В виде округленного числа с разделенными разрядами
 */

function formate_cost($form_cost) {
    $form_cost = ceil($form_cost);
    $form_cost = ($form_cost < 1000) ? $form_cost : number_format($form_cost, 0, '', ' ');
    return $form_cost . ' ' . '&#8381';
}

/** Возвращает разницу между текущей датой и переданной датой
 *
 * @param $date Дата в фомате 'ГГГГ-ММ-ДД', до которой надо вычислить разницу
 *
 * @return $diff Разница между сегодняшней датой и заданной дататой в формате 'ЧЧ:ММ'
*/

function get_dt_range($date) {
    $cur_date = date_create('now');
    $gen_date = date_create($date);
    $diff = date_diff($cur_date, $gen_date);
    return $diff->d * 24 + $diff->h . ':' . $diff->i;
}

/** Проверяет в форме данные поля "Категория" на существование в заданном списке
 *
 * @param $id Номер введенной категории
 * @param $allowed_list Название категории
 *
 * @return Отрицательный ответ, если ничего не совпадает, либо null, если все хорошо
 */

function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана не существующая категория";
    }
    return null;
}

/**  Проверяет число на положительное
 *
 * @param $value Введенное число
 *
 * @return Если число меньше 0, выведет ошибку
*/

function validatePositive($value) {
    if ($value <= 0) {
        return "Введите положительное число";
    }
    return null;
}

/** Проверяет дату окончания лота, чтобы она была не менее суток
 *
 * @param $date Дата введенная в поле окончания лота
 *
 * @return смотрит разницу между текущей датой и введенной датой и возвращает ошибку, если она меньше суток
 */

function validateDate($date) {
    $cur_date = date_create('now');
    $date = date_create($date);
    $diff = date_diff($cur_date, $date);
    if ($diff->h < 24) {
        return "Дата должна быть больше хотя бы на сутки";
    }
}

/** Фильтрует и сохраняет значение из формы
 *
 * @param $name Введенное значение в форму
 *
 * @return Возвращает отфильтрованное значение
 */

function getPostVal($name) {
    return filter_input(INPUT_POST, $name);
}

/** Возвращает разницу между текущей датой и переданной датой в минутах
 *
 * @param $date Дата в фомате 'ГГГГ-ММ-ДД', до которой надо вычислить разницу
 *
 * @return $diff Разница между сегодняшней датой и заданной дататой в минутах
*/

function diffDate($date) {
    $cur_date = date_create('now');
    $date = date_create($date);
    $diff = date_diff($cur_date, $date);
    return $diff->i;
}

?>
