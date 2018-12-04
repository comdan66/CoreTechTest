<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "ALTER TABLE `ShopMain` ADD `latitude` double DEFAULT NULL COMMENT '緯度' AFTER `latLong`;",

  'down' => "ALTER TABLE `ShopMain` DROP COLUMN `latitude`;",

  'at' => "2018-12-04 17:06:00"
];
