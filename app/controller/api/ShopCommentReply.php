<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopCommentReply extends ApiController {
  private $shop, $comment;
  public function __construct() {
    parent::__construct();

    if (!$this->shop = \M\ShopMain::one('id = ?', Router::params('shopId')))
      error('找不到資料！');

    if (!$this->comment = \M\ShopMainComment::one('id = ?', Router::params('id')))
      error('找不到資料！');
  }

  public function index() {
    $params = Input::get();

    validator(function() use (&$params) {
      Validator::need($params, 'min', '最小 ID', 0)->isNum()->greater(0);
    });

    return array_map(function($reply) {
      return [
        'id' => $reply->id,
        'name' => $reply->name,
        'content' => $reply->content,
        'createAt' => $reply->createAt->format('Y/m/d H:i'),
      ];
    }, \M\ShopMainCommentReply::all([
      'order' => 'id DESC',
      'where' => ['shopMainId = ? AND shopMainCommentId = ? AND id < ?', $this->shop->id, $this->comment->id, $params['min']]
    ]));
  }

  public function create() {
    $params = Input::post();
    
    validator(function() use (&$params) {
      Validator::need($params, 'name', '您的名字')->isVarchar(190);
      Validator::need($params, 'content', '內容')->isText();
      $params['shopMainId'] = $this->shop->id;
      $params['shopMainCommentId'] = $this->comment->id;
    });

    transaction(function() use (&$params, &$reply) {
      return $reply = \M\ShopMainCommentReply::create($params);
    });

    return [
      'id' => $reply->id,
      'name' => $reply->name,
      'content' => $reply->content,
      'createAt' => $reply->createAt->format('Y/m/d H:i'),
    ];
  }
}
