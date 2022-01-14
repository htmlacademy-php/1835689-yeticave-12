<?php

//функция округляет число и разделяет разряды

function formate_cost($form_cost) {
    $form_cost = ceil($form_cost);
    $form_cost = ($form_cost < 1000) ? $form_cost : number_format($form_cost, 0, '', ' ');
    return $form_cost . ' ' . '&#8381';
}

function get_dt_range($date) {
    $cur_date = date_create('now');
    $date = date_create($date);
    $diff = date_diff($cur_date, $date);
    return $diff->d * 24 + $diff->h . ':' . $diff->i;
}

//функция проверяет поле "Категория" на существующие в списке

function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана не существующая категория";
    }
    return null;
}

//функция проверяет на число больше нуля

function validatePositive($value) {
    if ($value <= 0) {
        return "Введите положительное число";
    }
    return null;
}

//функция проверяет конечную дату

function validateDate($date) {
    $cur_date = date_create('now');
    $date = date_create($date);
    $diff = date_diff($cur_date, $date);
    if ($diff->h < 24) {
        return "Дата должна быть больше хотя бы на сутки";
    }
}

//функция сохраняет введенное значение

function getPostVal($name) {
    return filter_input(INPUT_POST, $name);
}

?>
