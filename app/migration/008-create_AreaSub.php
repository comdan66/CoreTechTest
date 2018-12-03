<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "CREATE TABLE `AreaSub` (
    `id`         int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `areaMainId` int(11) unsigned NOT NULL COMMENT 'AreaMain ID',
    `name`       varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名稱',
    `sort`       int(11) unsigned NOT NULL DEFAULT 0 COMMENT '排序 ASC',
    `updateAt`   datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    `createAt`   datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

  'down' => "DROP TABLE `AreaSub`;",

  'at' => "2018-12-03 20:27:43"
];
