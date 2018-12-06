<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class FoodMain extends AdminCrudController {
  
  public function __construct() {
    parent::__construct();

    wtfTo('AdminFoodMainIndex');

    if (in_array(Router::methodName(), ['edit', 'update', 'delete']))
      ($this->obj = \M\FoodMain::one('id = ?', Router::params('id'))) || error('找不到資料！');

    $this->view->with('title', '分類上稿')
               ->with('currentUrl', Url::toRouter('AdminFoodMainIndex'));
  }

  public function index() {
    $list = AdminList::create('\M\FoodMain', ['include' => 'subs'])
                     ->setAddUrl(Url::toRouter('AdminFoodMainAdd'))
                     ->setSortUrl(Url::toRouter('AdminFoodMainSort'));

    return $this->view->with('list', $list);
  }
  
  public function add() {
    $form = AdminForm::create()
                     ->setActionUrl(Url::toRouter('AdminFoodMainCreate'))
                     ->setBackUrl(Url::toRouter('AdminFoodMainIndex'));

    return $this->view->with('form', $form);
  }
  
  public function create() {
    wtfTo('AdminFoodMainAdd');

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
      $params['sort'] = \M\FoodMain::count();
    });

    transaction(function() use (&$params) {
      return \M\FoodMain::create($params);
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminFoodMainIndex'), '新增成功！');
  }
  
  public function edit() {
    $form = AdminForm::create($this->obj)
                    ->setActionUrl(Url::toRouter('AdminFoodMainUpdate', $this->obj))
                    ->setBackUrl(Url::toRouter('AdminFoodMainIndex'));

    return $this->view->with('form', $form);
  }
  
  public function update() {
    wtfTo('AdminFoodMainEdit', $this->obj);

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
    });

    transaction(function() use (&$params) {
      return $this->obj->columnsUpdate($params) && $this->obj->save();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminFoodMainIndex'), '修改成功！');
  }
  
  public function delete() {
    wtfTo('AdminFoodMainIndex');
    
    transaction(function() {
      return $this->obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminFoodMainIndex'), '刪除成功！');
  }

  public function sort() {
    $params = Input::post();
    
    validator(function() use (&$params) {
      $params['changes'] = array_filter(array_map(function($change) {
        if (!isset($change['id'], $change['ori'], $change['now']))
          return null;

        if (!$obj = \M\FoodMain::one(['select' => 'id,sort', 'where' => ['id = ? AND sort = ?', $change['id'], $change['ori']]]))
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
