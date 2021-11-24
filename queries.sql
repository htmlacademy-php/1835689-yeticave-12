
SELECT `l`.`id`, `dt_add`, `user_id`, `title`, `description`, `image`, `cost`, `dt_end`, `step`, `name` FROM `lots` `l` JOIN `categories` `c` ON `l`.`category_id` = `c`.`id`;
SELECT `r`.`dt_add`, `cost_rate` FROM `rates` `r` JOIN `lots` `l` ON `r`.`lot_id` = `l`.`id` WHERE `l`.`id` = 6;