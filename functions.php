<?php

function formate_cost($form_cost) {
    $form_cost = ceil($form_cost);
    $form_cost = ($form_cost < 1000) ? $form_cost : number_format($form_cost, 0, '', ' ');
    return $form_cost . ' ' . '&#8381';
};

function get_dt_range($date) {
    $cur_date = date_create('now');
    $date = date_create($date);
    $diff = date_diff($cur_date, $date);
    return $diff->d * 24 + $diff->h . ':' . $diff->i;
};
?>