<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => [
    "ALTER TABLE `ShopMain` ADD `latitude` double DEFAULT NULL COMMENT '緯度' AFTER `latLong`;",
    "ALTER TABLE `ShopMain` ADD `longitude` double DEFAULT NULL COMMENT '經度' AFTER `latitude`;"
  ],

  'down' => [
    "ALTER TABLE `ShopMain` DROP COLUMN `longitude`;",
    "ALTER TABLE `ShopMain` DROP COLUMN `latitude`;"
  ],

  'at' => "2018-12-04 17:06:00"
];
