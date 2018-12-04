<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopComment extends SiteController {
  private $shop = null;
  private $message = null;
  
  public function __construct() {
    parent::__construct();

    // $this->shop = \M\Adv::one('id = ?', Router::params('advId'));
    // $this->shop || error('此廣告不存在！');

    // $this->shop->status != \M\Adv::STATUS_YET || error('此廣告尚未審過！');

    // if (in_array(Router::methodName(), ['update', 'delete']))
    //   ($this->message = \M\AdvMessage::one('id = ? AND advId = ?', Router::params('id'), $this->adv->id)) || error('此留言不存在！');

    // // 留言者自己才可
    // if (in_array(Router::methodName(), ['update', 'delete']))
    //   $this->message->userId == $this->identity->id || error('權限錯誤！');
  }

  public function index() {
    $this->asset
         ->addCSS('/asset/css/site/ShopComment/index.css')
         ->addJS('/asset/js/site/ShopComment/index.js');

    return $this->view;
  }
}
