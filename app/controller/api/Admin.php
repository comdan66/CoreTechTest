<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Admin extends ApiController {
  public function areaSubId() {
    $params = Router::params();

    validator(function() use (&$params) {
      Validator::need($params, 'id', '縣市 ID')->isId('\M\AreaMain');
    });

    return array_map(function($areaSub) { return [
      'id' => $areaSub->id,
      'name' => $areaSub->name,
    ]; }, \M\AreaSub::all(['order' => 'sort ASC', 'where' => ['areaMainId = ?', $params['id']]]));
  }

  public function foodSubId() {
    $params = Router::params();

    validator(function() use (&$params) {
      Validator::need($params, 'id', '分類 ID')->isId('\M\FoodMain');
    });

    return array_map(function($foodSub) { return [
      'id' => $foodSub->id,
      'name' => $foodSub->name,
    ]; }, \M\FoodSub::all(['order' => 'sort ASC', 'where' => ['foodMainId = ?', $params['id']]]));
  }
}
