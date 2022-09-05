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
    $cur_date = date_create('now');
    $gen_date = date_create($date);
    $diff = date_diff($gen_date, $cur_date);
    return $diff->d * 24 + $diff->h . ':' . $diff->i;
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
    $cur_date = date_create('now');
    $date = date_create($date);
    $diff = date_diff($cur_date, $date);
    return $diff->i;
}

?>
