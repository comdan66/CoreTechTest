<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class AreaMain extends Model {
  // static $hasOne = [];

  static $hasMany = [
    'subs' => ['model' => 'AreaSub', 'order' => 'sort ASC']
  ];

  // static $belongToOne = [];

  // static $belongToMany = [];

  // static $uploaders = [];

  public function delete() {
    foreach ($this->subs as $sub)
      if (!$sub->delete())
        return false;

    foreach (ShopMain::all(['select' => 'id, areaMainId, updateAt', 'where' => ['areaMainId = ?', $this->id]]) as $shop)
      if (!($shop->areaMainId = 0) && !$shop->save())
        return false;

    return parent::delete();
  }
}
