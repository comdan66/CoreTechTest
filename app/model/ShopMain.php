<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopMain extends Model {
  // static $hasOne = [];

  static $hasMany = [
    'photos' => ['model' => 'ShopPhoto', 'order' => 'sort ASC'],
    'shopFoods' => 'ShopFood',
    'comments' => 'ShopMainComment',
    'foods' => ['model' => 'FoodSub', 'by' => 'shopFood'],
  ];

  static $belongToOne = [
    'areaMain' => 'AreaMain',
    'areaSub' => 'AreaSub',
    'foodMain' => 'FoodMain',
  ];

  // static $belongToMany = [];

  // static $uploaders = [];

  public function delete() {
    foreach ($this->photos as $photo)
      if (!$photo->delete())
        return false;

    foreach ($this->shopFoods as $shopFood)
      if (!$shopFood->delete())
        return false;

    foreach ($this->comments as $comment)
      if (!$comment->delete())
        return false;

    return parent::delete();
  }
}
