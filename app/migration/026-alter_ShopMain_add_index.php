<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "ALTER TABLE `ShopMain` ADD INDEX `areaSubId_index`(`areaSubId`);",

  'down' => "ALTER TABLE `ShopMain` DROP INDEX `areaSubId_index`;",

  'at' => "2018-12-08 11:51:39"
];
