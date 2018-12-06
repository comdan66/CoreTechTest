<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopMainCommentReply extends AdminCrudController {
  private $grand = null;
  
  public function __construct() {
    parent::__construct();

    wtfTo('AdminShopMainIndex');
    $this->grand = \M\ShopMain::one('id = ?', Router::params('shopId'));
    $this->grand || error('找不到資料！');

    wtfTo('AdminShopMainCommentIndex', $this->grand);

    $this->parent = \M\ShopMainComment::one('id = ?', Router::params('commentId'));
    $this->parent || error('找不到資料！');

    wtfTo('AdminShopMainCommentReplyIndex', $this->grand, $this->parent);

    if (in_array(Router::methodName(), ['delete', 'show']))
      if (!$this->obj = \M\ShopMainCommentReply::one('id = ?', Router::params('id')))
        error('找不到資料！');

    $this->view->with('title', ['商店上稿', $this->grand->name, $this->parent->name])
               ->with('currentUrl', Url::toRouter('AdminShopMainIndex'))
               ->with('grand', $this->grand)
               ->with('parent', $this->parent);
  }

  public function index() {
    $list = AdminList::create('\M\ShopMainCommentReply', ['where' => ['shopMainId = ? AND shopMainCommentId = ?', $this->grand->id, $this->parent->id]]);

    $show = AdminShow::create($this->grand)
                     ->setBackUrl(Url::toRouter('AdminShopMainCommentIndex', $this->grand), '留言列表');

    return $this->view->with('list', $list)
                      ->with('show', $show);
  }

  public function show() {
    $show = AdminShow::create($this->obj)
                     ->setBackUrl(Url::toRouter('AdminShopMainCommentReplyIndex', $this->grand, $this->parent), '回覆列表');

    return $this->view->with('show', $show);
  }

  public function delete() {
    wtfTo('AdminShopMainCommentReplyIndex', $this->grand, $this->parent);
    
    transaction(function() {
      return $this->obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminShopMainCommentReplyIndex', $this->grand, $this->parent), '刪除成功！');
  }
}