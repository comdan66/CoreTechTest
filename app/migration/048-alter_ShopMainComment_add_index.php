<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "ALTER TABLE `ShopMainComment` ADD INDEX `shopMainId_index`(`shopMainId`);",

  'down' => "ALTER TABLE `ShopMainComment` DROP INDEX `shopMainId_index`;",

  'at' => "2018-12-08 11:53:11"
];
