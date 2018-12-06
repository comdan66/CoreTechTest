<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class FoodSub extends Model {
  // static $hasOne = [];

  static $hasMany = [
    'shopFood' => 'ShopFood'
  ];

  // static $belongToOne = [];

  // static $belongToMany = [];

  // static $uploaders = [];
  
  public function delete() {
    foreach (ShopFood::all(['select' => 'id, updateAt', 'where' => ['foodSubId = ?', $this->id]]) as $shopFood)
      if (!$shopFood->delete())
        return false;

    return parent::delete();
  }
}
