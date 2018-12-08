<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => [
    "UPDATE `ShopMain` SET  `latitude` = SUBSTRING_INDEX(`latLong`, ',',1);",
    "UPDATE `ShopMain` SET  `longitude` = SUBSTRING_INDEX(`latLong`, ',',-1);"
  ],

  'down' => [
    "UPDATE `ShopMain` SET  `longitude` = NULL;",
    "UPDATE `ShopMain` SET  `latitude` = NULL;"
  ],

  'at' => "2018-12-04 20:25:15"
];
