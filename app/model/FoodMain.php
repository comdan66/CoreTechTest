<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class FoodMain extends Model {
  // static $hasOne = [];

  static $hasMany = [
    'subs' => 'FoodSub'
  ];

  // static $belongToOne = [];

  // static $belongToMany = [];

  // static $uploaders = [];

  public function delete() {
    foreach ($this->subs as $sub)
      if (!$sub->delete())
        return false;

    foreach (ShopMain::all(['select' => 'id, foodMainId, updateAt', 'where' => ['foodMainId = ?', $this->id]]) as $shop)
      if (!($shop->foodMainId = 0) && !$shop->save())
        return false;

    return parent::delete();
  }
}
