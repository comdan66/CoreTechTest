<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Crontab extends AdminCrudController {
  
  public function __construct() {
    parent::__construct(\M\AdminRole::ROLE_ROOT);

    if (in_array(Router::methodName(), ['show', 'read']))
      if (!(($id = Router::params('id')) && ($this->obj = \M\Crontab::one('id = ?', $id))))
        Url::refreshWithFailureFlash(Url::toRouter('AdminCrontabIndex'), '找不到資料！');

    $this->view->with('title', '每日備份')
               ->with('currentUrl', Url::toRouter('AdminCrontabIndex'));
  }

  public function index() {
    $list = AdminList::create('\M\Crontab');

    return $this->view->with('list', $list);
  }
  
  public function show() {
    $show = AdminShow::create($this->obj)
                     ->setBackUrl(Url::toRouter('AdminCrontabIndex'), '回列表');

    return $this->view->with('show', $show);
  }

  public function read() {
    wtf(function() {
      return ['messages' => func_get_args()];
    });

    $params = Input::post();
    
    validator(function() use (&$params) {
      Validator::need($params, 'isRead', '已讀')->inEnum(\M\Crontab::IS_READ);
    });
    
    transaction(function() use (&$params) {
      return $this->obj->columnsUpdate($params) && $this->obj->save();
    });

    return $params;
  }
}