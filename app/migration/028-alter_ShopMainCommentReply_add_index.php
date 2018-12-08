<?php defined('MAPLE') || exit('此檔案不允許讀取！');

return [
  'up' => "ALTER TABLE `ShopMainCommentReply` ADD INDEX `shopMainId_shopMainCommentId_index`(`shopMainId`, `shopMainCommentId`);",

  'down' => "ALTER TABLE `ShopMainCommentReply` DROP INDEX `shopMainId_shopMainCommentId_index`;",

  'at' => "2018-12-08 11:53:27"
];
