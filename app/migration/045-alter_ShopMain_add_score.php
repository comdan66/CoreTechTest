<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "ALTER TABLE `ShopMain` ADD `score` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT 'Score' AFTER `info`;",

  'down' => "ALTER TABLE `ShopMain` DROP COLUMN `score`;",

  'at' => "2018-12-04 23:10:26"
];
