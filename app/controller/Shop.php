<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Shop extends SiteController {
  public function __construct() {
    parent::__construct();

    wtfTo('ShopIndex');

    Load::sysLib('Html.php');
    Load::sysLib('Pagination.php');

    Pagination::$firstClass  = '';
    Pagination::$lastClass   = '';
    Pagination::$firstText   = '';
    Pagination::$lastText    = '';
    Pagination::$prevText    = '';
    Pagination::$nextText    = '';
    Pagination::$prevClass   = 'p';
    Pagination::$activeClass = 'a';
    Pagination::$nextClass   = 'n';
  }

  public function index() {
    $this->asset->addCSS('/asset/css/site/Shop/list.css');
    
    $params = Input::get();
    $this->validator($params);

    if (count($params['area']) == 1 && count($params['food']) == 1) {
      $h1 = $params['area'][0]->main->name . '/' . $params['area'][0]->name . '/' . $params['food'][0]->main->name . '/' . $params['food'][0]->name . ' 美食排行榜';
      $tag = $params['area'][0]->main->name . '/' . $params['area'][0]->name . '/' . $params['food'][0]->main->name . '/' . $params['food'][0]->name . ' 排行榜';
      $nav = [
        Url::toRouterHyperlink('ShopIndex')->text('首頁'),
        Hyperlink::create(Url::toRouter('ShopIndex') . '?' . implode('&', array_map(function($sub) { return 'area[]=' . $sub->id; }, $params['area'][0]->main->subs)))->text($params['area'][0]->main->name . ' 排行榜'),
        '美食排行榜'];
    } else {
      $h1 = '美食排行榜';
      $tag = '美食排行榜結果';
      $nav = [
        Url::toRouterHyperlink('ShopIndex')->text('首頁'),
        '美食排行榜'];
    }

    if (count($params['area']) == 1) {
      $nav = [
        Url::toRouterHyperlink('ShopIndex')->text('首頁'),
        Hyperlink::create(Url::toRouter('ShopIndex') . '?' . implode('&', array_map(function($sub) { return 'area[]=' . $sub->id; }, $params['area'][0]->main->subs)))->text($params['area'][0]->main->name . ' 排行榜'),
        '美食排行榜'];
    }

    $area = $this->area($params);
    $food = $this->food($params);

    $where = $this->where($params);
    $total = \M\ShopMain::count($where);
    $page = Pagination::info($total, 20, 2);

    $shopMains = \M\ShopMain::all([
      'offset' => $page['offset'],
      'limit' => $page['limit'],
      'include' => ['photos', 'foodMain', 'foods'],
      'order' => 'score DESC, id DESC',
      'where' => $where]);

    return $this->view->with('h1', $h1)
                      ->with('nav', $nav)
                      ->with('tag', $tag)
                      ->with('page', $page)
                      ->with('area', $area)
                      ->with('food', $food)
                      ->with('shopMains', $shopMains);
  }

  public function search() {
    $this->asset->addCSS('/asset/css/site/Shop/list.css');
    
    $params = Input::get();
    $this->validator($params);

    if (count($params['area']) == 1 && count($params['food']) == 1) {
      $h1 = $params['area'][0]->main->name . '/' . $params['area'][0]->name . '/' . $params['food'][0]->main->name . '/' . $params['food'][0]->name . ' 美食查詢';
      $tag = $params['area'][0]->main->name . '/' . $params['area'][0]->name . '/' . $params['food'][0]->main->name . '/' . $params['food'][0]->name . ' 查詢結果';
      $nav = [
        Url::toRouterHyperlink('ShopSearch')->text('首頁'),
        Hyperlink::create(Url::toRouter('ShopSearch') . '?' . implode('&', array_map(function($sub) { return 'area[]=' . $sub->id; }, $params['area'][0]->main->subs)))->text($params['area'][0]->main->name . ' 排行榜'),
        '查詢結果'];
    } else {
      $h1 = '美食查詢結果';
      $tag = '美食查詢結果';
      $nav = [
        Url::toRouterHyperlink('ShopSearch')->text('首頁'),
        '查詢結果'];
    }

    if (count($params['area']) == 1) {
      $nav = [
        Url::toRouterHyperlink('ShopSearch')->text('首頁'),
        Hyperlink::create(Url::toRouter('ShopSearch') . '?' . implode('&', array_map(function($sub) { return 'area[]=' . $sub->id; }, $params['area'][0]->main->subs)))->text($params['area'][0]->main->name . ' 排行榜'),
        '查詢結果'];
    }

    $area = $this->area($params);
    $food = $this->food($params);

    $where = $this->where($params);
    $total = \M\ShopMain::count($where);
    $page = Pagination::info($total, 20, 2);

    $shopMains = \M\ShopMain::all([
      'offset' => $page['offset'],
      'limit' => $page['limit'],
      'include' => ['photos', 'foodMain', 'foods'],
      'order' => 'id DESC',
      'where' => $where]);

    return $this->view->with('h1', $h1)
                      ->with('nav', $nav)
                      ->with('tag', $tag)
                      ->with('page', $page)
                      ->with('area', $area)
                      ->with('food', $food)
                      ->with('shopMains', $shopMains);
  }

  public function show() {
    $this->asset
         ->addCSS('/asset/css/site/Shop/show.css');
    return $this->view;
  }
  
  private function validator(&$params) {
    validator(function() use (&$params) {
      Validator::maybe($params, 'area', '區域', [])->isArray();
      Validator::maybe($params, 'food', '食物', [])->isArray();

      $params['area'] = \M\AreaSub::all(['select' => 'id, areaMainId, name', 'where' => ['id IN (?)', $params['area']]]);
      $params['food'] = \M\FoodSub::all(['select' => 'id, foodMainId, name', 'where' => ['id IN (?)', $params['food']]]);
    });
  }

  private function area(&$params) {
    $params['area'] = arrayColumn($params['area'], 'id');

    return array_map(function($main) use ($params) {
      $subs = array_merge([[
          'type' => 'checkbox',
          'name' => 'area[]',
          'value' => -1,
          'checked' => $params && in_array(-1, $params['area']),
          'text' => '全' . $main->name
        ]], array_map(function($sub) use ($params) {
        return [
          'type' => 'checkbox',
          'name' => 'area[]',
          'value' => $sub->id,
          'checked' => $params && in_array($sub->id, $params['area']),
          'text' => $sub->name
        ];
      }, $main->subs));

      $checked = array_filter(array_column($subs, 'checked'));
      count($checked) == count($main->subs) && $subs[0]['value'] == -1 && $subs[0]['checked'] = true;

      return [
        'text' => $main->name,
        'subs' => $subs,
        'class' => $checked ? 'active' : false
      ];
    }, \M\AreaMain::all(['select' => 'id, name', 'include' => ['subs'], 'order' => 'sort ASC']));
  }

  private function food(&$params) {
    $params['food'] = arrayColumn($params['food'], 'id');

    return array_map(function($main) use ($params) {
      $subs = array_merge([[
          'type' => 'checkbox',
          'name' => 'food[]',
          'value' => -1,
          'checked' => $params && in_array(-1, $params['food']),
          'text' => '全' . $main->name
        ]],array_map(function($sub) use ($params) {
        return [
          'type' => 'checkbox',
          'name' => 'food[]',
          'value' => $sub->id,
          'checked' => $params && in_array($sub->id, $params['food']),
          'text' => $sub->name
        ];
      }, $main->subs));

      $checked = array_filter(array_column($subs, 'checked'));
      count($checked) == count($main->subs) && $subs[0]['value'] == -1 && $subs[0]['checked'] = true;

      return [
        'text' => $main->name,
        'subs' => $subs,
        'class' => $checked ? 'active' : false
      ];
    }, \M\FoodMain::all(['select' => 'id, name', 'include' => ['subs'], 'order' => 'sort ASC']));
  }

  private function where($params) {
    $where = Where::create();

    $params['area'] && $where->and('areaSubId IN (?)', $params['area']);
    $params['food'] && $where->and('id IN (?)', array_unique(\M\ShopFood::arr('shopMainId', 'foodSubId IN (?)', $params['food'])));

    return $where;
  }
}
