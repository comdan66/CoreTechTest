<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "CREATE TABLE `ShopMain` (
    `id`         int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `name`       varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名稱',
    `areaMainId` int(11) unsigned NOT NULL COMMENT 'AreaMain ID',
    `areaSubId`  int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'AreaSub ID',
    `foodMainId` int(11) unsigned NOT NULL COMMENT 'FoodMain ID',
    `title`      text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '標題',
    `text`       text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文字',
    `latLong`    varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '經緯度，逗號隔開',
    `tel`        varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '電話號碼',
    `address`    varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
    `station`    text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '捷運站',
    `holiday`    text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '休假日',
    `openTime`   text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '營業時間',
    `info`       text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '資訊',
    `updateAt`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    `createAt`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

  'down' => "DROP TABLE `ShopMain`;",

  'at' => "2018-12-03 20:28:36"
];
