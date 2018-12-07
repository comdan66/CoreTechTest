<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopComment extends SiteController {
  private $shop;

  public function __construct() {
    parent::__construct();

    wtfTo('ShopIndex');

    if (!$this->shop = \M\ShopMain::one('id = ?', Router::params('id')))
      error('找不到資料！');

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
    $this->asset
         ->addCSS('/asset/css/site/ShopComment/index.css')
         ->addJS('/asset/js/site/ShopComment/index.js');

    $where = Where::create('shopMainId = ?', $this->shop->id);
    $total = \M\ShopMainComment::count($where);
    $page = Pagination::info($total, 20, 2);

    $comments = \M\ShopMainComment::all([
      'offset' => $page['offset'],
      'limit' => $page['limit'],
      'include' => ['photos', 'foodMain', 'foods'],
      'order' => 'score DESC, id DESC',
      'where' => $where]);

    $flash = Session::getFlashData('flash');
    !isset($flash['params']) || $flash['params'] || $flash['params'] = null;

    return $this->view->with('h1', $this->shop->name . '-' . $this->shop->areaMain->name . ' ' . $this->shop->areaSub->name . '-')
                      ->with('nav', [
                        Url::toRouterHyperlink('ShopSearch')->text('首頁'),
                        Hyperlink::create(Url::toRouter('ShopSearch') . '?' . implode('&', array_map(function($sub) { return 'area[]=' . $sub->id; }, $this->shop->areaMain->subs)))->text($this->shop->areaMain->name),
                        Hyperlink::create(Url::toRouter('ShopSearch') . '?' . 'area[]=' . $this->shop->areaSub->id)->text($this->shop->areaMain->name . '・' . $this->shop->areaSub->name),
                        $this->shop->name . '-' . $this->shop->areaMain->name . '-'
                      ])
                      ->with('page', $page)
                      ->with('shop', $this->shop)
                      ->with('flash', $flash)
                      ->with('comments', $comments);
  }
  public function create() {
    wtfTo('ShopCommentIndex', $this->shop);

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '您的名字')->isVarchar(190);
      Validator::need($params, 'score', '評分')->isNum()->greaterEqual(0)->lessEqual(100);
      Validator::need($params, 'title', '標題')->isVarchar(190);
      Validator::need($params, 'content', '分享文')->isText();
      $params['shopMainId'] = $this->shop->id;
    });

    transaction(function() use (&$params) {
      return \M\ShopMainComment::create($params);
    });

    Url::refreshWithSuccessFlash(Url::toRouter('ShopCommentIndex', $this->shop), '新增成功！');
  }
}
