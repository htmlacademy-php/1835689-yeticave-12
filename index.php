<?php

require_once('helpers.php');
require_once('functions.php');

$link = mysqli_connect("localhost", "root", "", "yetycave");
mysqli_set_charset($link, "utf8");

if(!$link) {
   $error = mysqli_connect_error();
   $content = include_template('error.php', ['error' => $error]);
}
else {
   $sql = 'SELECT * FROM categories';

   if ($res = mysqli_query($link, $sql)) {
      $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
      $sql = 'SELECT `dt_add`, `title`, `image`, `cost`, `categories`.`name` FROM `lots`'
         . 'JOIN `categories` ON `lots`.`category_id` = `categories`.`id`'
         . 'ORDER BY `dt_add` DESC LIMIT 6';
         if($res = mysqli_query($link, $sql)) {
            $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
         }

         else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
         }
      }
      else {
         $error = mysqli_error($link);
         $content = include_template('error.php', ['error' => $error]);
      }
}

print(include_template('layout.php', ['content' => $content, 'title' => 'YetiCave', 'categories' => $categories]));
    ?>