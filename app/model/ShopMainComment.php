<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopMainComment extends Model {
  // static $hasOne = [];

  static $hasMany = [
    'replies' => 'ShopMainCommentReply',
  ];

  static $belongToOne = [
    'shop' => 'ShopMain'
  ];

  // static $belongToMany = [];

  // static $uploaders = [];

  static $afterCreates = ['updateShopScore'];

  public function delete() {
    foreach ($this->replies as $reply)
      if (!$reply->delete())
        return false;

    return parent::delete();
  }

  public function updateShopScore() {
    $scores = self::arr('score', 'shopMainId = ?', $this->shopMainId);
    $this->shop->score = array_sum($scores)/count($scores);
    return $this->shop->save();
  }
}
