<?php

$link = mysqli_connect("1835689-yeticave-12", "root", "", "yetycave");
mysqli_set_charset($link, "utf8");

if(!$link) {
   $error = mysqli_connect_error();
   $content = include_template('error.php', ['error' => $error]);
   print(include_template('layout-error.php', ['content' => $content]));
   exit();
}
