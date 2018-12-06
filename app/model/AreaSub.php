<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class AreaSub extends Model {
  // static $hasOne = [];

  // static $hasMany = [];

  static $belongToOne = [
    'main' => 'AreaMain'
  ];

  // static $belongToMany = [];

  // static $uploaders = [];

  public function delete() {
    foreach (ShopMain::all(['select' => 'id, areaSubId, updateAt', 'where' => ['areaSubId = ?', $this->id]]) as $shop)
      if (!($shop->areaSubId = 0) && !$shop->save())
        return false;

    return parent::delete();
  }
}
