<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class AreaMain extends AdminCrudController {
  
  public function __construct() {
    parent::__construct();

    wtfTo('AdminAreaMainIndex');

    if (in_array(Router::methodName(), ['edit', 'update', 'delete']))
      ($this->obj = \M\AreaMain::one('id = ?', Router::params('id'))) || error('找不到資料！');

    $this->view->with('title', '縣市上稿')
               ->with('currentUrl', Url::toRouter('AdminAreaMainIndex'));
  }

  public function index() {
    $list = AdminList::create('\M\AreaMain', ['include' => 'subs'])
                     ->setAddUrl(Url::toRouter('AdminAreaMainAdd'))
                     ->setSortUrl(Url::toRouter('AdminAreaMainSort'));

    return $this->view->with('list', $list);
  }
  
  public function add() {
    $form = AdminForm::create()
                     ->setActionUrl(Url::toRouter('AdminAreaMainCreate'))
                     ->setBackUrl(Url::toRouter('AdminAreaMainIndex'));

    return $this->view->with('form', $form);
  }
  
  public function create() {
    wtfTo('AdminAreaMainAdd');

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
      $params['sort'] = \M\AreaMain::count();
    });

    transaction(function() use (&$params) {
      return \M\AreaMain::create($params);
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminAreaMainIndex'), '新增成功！');
  }
  
  public function edit() {
    $form = AdminForm::create($this->obj)
                    ->setActionUrl(Url::toRouter('AdminAreaMainUpdate', $this->obj))
                    ->setBackUrl(Url::toRouter('AdminAreaMainIndex'));

    return $this->view->with('form', $form);
  }
  
  public function update() {
    wtfTo('AdminAreaMainEdit', $this->obj);

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
    });

    transaction(function() use (&$params) {
      return $this->obj->columnsUpdate($params) && $this->obj->save();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminAreaMainIndex'), '修改成功！');
  }
  
  public function delete() {
    wtfTo('AdminAreaMainIndex');
    
    transaction(function() {
      return $this->obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminAreaMainIndex'), '刪除成功！');
  }

  public function sort() {
    $params = Input::post();
    
    validator(function() use (&$params) {
      $params['changes'] = array_filter(array_map(function($change) {
        if (!isset($change['id'], $change['ori'], $change['now']))
          return null;

        if (!$obj = \M\AreaMain::one(['select' => 'id,sort', 'where' => ['id = ? AND sort = ?', $change['id'], $change['ori']]]))
          return null;

        return ['obj' => $obj, 'sort' => $change['now']];
      }, isset($params['changes']) ? $params['changes'] : []));
    });

    transaction(function() use (&$params) {
      foreach ($params['changes'] as $change)
        $change['obj']->sort = $change['sort'];

      foreach ($params['changes'] as $change)
        if (!$change['obj']->save())
          return false;

      return true;
    });

    return array_map(function($change) { return ['id' => $change['obj']->id, 'sort' => $change['obj']->sort]; }, $params['changes']);
  }
}
