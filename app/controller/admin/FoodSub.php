<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class FoodSub extends AdminCrudController {
  
  public function __construct() {
    parent::__construct();

    wtfTo('AdminFoodMainIndex');
    $this->parent = \M\FoodSub::one('id = ?', Router::params('mainId'));
    $this->parent || error('找不到資料！');

    wtfTo('AdminFoodSubIndex', $this->parent);

    if (in_array(Router::methodName(), ['edit', 'update', 'delete']))
      if (!$this->obj = \M\FoodSub::one('id = ?', Router::params('id')))
        error('找不到資料！');

    $this->view->with('title', ['分類上稿', $this->parent->name])
               ->with('currentUrl', Url::toRouter('AdminFoodMainIndex'))
               ->with('parent', $this->parent);
  }

  public function index() {
    $list = AdminList::create('\M\FoodSub', ['where' => ['foodMainId = ?', $this->parent->id]])
                     ->setAddUrl(Url::toRouter('AdminFoodSubAdd', $this->parent))
                     ->setSortUrl(Url::toRouter('AdminFoodSubSort', $this->parent));

    $show = AdminShow::create($this->parent)
                     ->setBackUrl(Url::toRouter('AdminFoodMainIndex'), '回縣市頁');

    return $this->view->with('list', $list)
                      ->with('show', $show);
  }

  public function add() {
    $form = AdminForm::create()
                     ->setActionUrl(Url::toRouter('AdminFoodSubCreate', $this->parent))
                     ->setBackUrl(Url::toRouter('AdminFoodSubIndex', $this->parent));

    return $this->view->with('form', $form);
  }

  public function create() {
    wtfTo('AdminFoodSubAdd', $this->parent);

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '標題')->isVarchar(190);
      $params['foodMainId'] = $this->parent->id;
      $params['sort'] = \M\FoodSub::count('foodMainId = ?', $this->parent->id);
    });

    transaction(function() use (&$params) {
      return \M\FoodSub::create($params);
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminFoodSubIndex', $this->parent), '新增成功！');
  }

  public function edit() {
    $form = AdminForm::create($this->obj)
                    ->setActionUrl(Url::toRouter('AdminFoodSubUpdate', $this->parent, $this->obj))
                    ->setBackUrl(Url::toRouter('AdminFoodSubIndex', $this->parent));

    return $this->view->with('form', $form);
  } 

  public function update() {
    wtfTo('AdminFoodSubEdit', $this->parent, $this->obj);

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '標題')->isVarchar(190);
    });

    transaction(function() use (&$params) {
      return $this->obj->columnsUpdate($params) && $this->obj->save();
    });
    
    Url::refreshWithSuccessFlash(Url::toRouter('AdminFoodSubIndex', $this->parent), '修改成功！');
  }

  public function delete() {
    wtfTo('AdminFoodSubIndex', $this->parent);
    
    transaction(function() {
      return $this->obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminFoodSubIndex', $this->parent), '刪除成功！');
  }
  public function sort() {
    $params = Input::post();
    
    validator(function() use (&$params) {
      $params['changes'] = array_filter(array_map(function($change) {
        if (!isset($change['id'], $change['ori'], $change['now']))
          return null;

        if (!$obj = \M\FoodSub::one(['select' => 'id,sort', 'where' => ['id = ? AND sort = ?', $change['id'], $change['ori']]]))
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