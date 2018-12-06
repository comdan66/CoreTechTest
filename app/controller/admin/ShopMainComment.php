<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopMainComment extends AdminCrudController {
  
  public function __construct() {
    parent::__construct();

    wtfTo('AdminShopMainIndex');
    $this->parent = \M\ShopMain::one('id = ?', Router::params('shopId'));
    $this->parent || error('找不到資料！');

    wtfTo('AdminShopMainCommentIndex', $this->parent);

    if (in_array(Router::methodName(), ['delete', 'show']))
      if (!$this->obj = \M\ShopMainComment::one('id = ?', Router::params('id')))
        error('找不到資料！');

    $this->view->with('title', ['商店上稿', $this->parent->name])
               ->with('currentUrl', Url::toRouter('AdminShopMainIndex'))
               ->with('parent', $this->parent);
  }

  public function index() {
    $list = AdminList::create('\M\ShopMainComment', ['where' => ['shopMainId = ?', $this->parent->id]]);

    $show = AdminShow::create($this->parent)
                     ->setBackUrl(Url::toRouter('AdminShopMainIndex'), '商店列表');

    return $this->view->with('list', $list)
                      ->with('show', $show);
  }

  public function show() {
    $show = AdminShow::create($this->obj)
                     ->setBackUrl(Url::toRouter('AdminShopMainCommentIndex', $this->parent), '回列表');

    return $this->view->with('show', $show);
  }

  public function delete() {
    wtfTo('AdminShopMainCommentIndex', $this->parent);
    
    transaction(function() {
      return $this->obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminShopMainCommentIndex', $this->parent), '刪除成功！');
  }
}