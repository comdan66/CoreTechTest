<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "CREATE TABLE `ShopFood` (
    `id`         int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `shopMainId` int(11) unsigned NOT NULL COMMENT 'ShopMain ID',
    `foodSubId`  int(11) unsigned NOT NULL COMMENT 'FoodSub ID',
    `updateAt`   datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    `createAt`   datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

  'down' => "DROP TABLE `ShopFood`;",

  'at' => "2018-12-03 20:28:24"
];
