<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "CREATE TABLE `ShopPhoto` (
    `id`        int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `shopMainId`int(11) unsigned NOT NULL COMMENT 'ShopMain ID',
    `photoNum`  int(11) unsigned NOT NULL DEFAULT 0 COMMENT '原始資料 Num',
    `filename`  varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '檔案名稱',
    `updateAt`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    `createAt`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

  'down' => "DROP TABLE `ShopPhoto`;",

  'at' => "2018-12-03 20:28:58"
];
