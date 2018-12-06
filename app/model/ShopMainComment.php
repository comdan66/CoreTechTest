<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopMainComment extends Model {
  // static $hasOne = [];

  static $hasMany = [
    'replies' => 'ShopMainCommentReply',
  ];

  // static $belongToOne = [];

  // static $belongToMany = [];

  // static $uploaders = [];

  public function delete() {
    foreach ($this->replies as $reply)
      if (!$reply->delete())
        return false;

    return parent::delete();
  }
}
