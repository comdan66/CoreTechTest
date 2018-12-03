<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Admin extends AdminCrudController {
  private $ignoreIds;
  
  public function __construct() {
    parent::__construct();

    wtfTo('AdminAdminIndex');

    $this->ignoreIds = [1];

    if (in_array(Router::methodName(), ['edit', 'update', 'delete', 'show']))
      if (!$this->obj = \M\Admin::one('id = ? AND id NOT IN(?)', Router::params('id'), $this->ignoreIds))
        error('找不到資料！');

    $this->view->with('title', '管理員帳號')
               ->with('currentUrl', Url::toRouter('AdminAdminIndex'));
  }

  public function index() {
    $where = Where::create('id NOT IN(?)', $this->ignoreIds);

    $list = AdminList::create('\M\Admin', ['include' => ['roles'], 'where' => $where])
                     ->setAddUrl(Url::toRouter('AdminAdminAdd'));

    return $this->view->with('list', $list);
  }
  
  public function add() {
    $form = AdminForm::create()
                     ->setActionUrl(Url::toRouter('AdminAdminCreate'))
                     ->setBackUrl(Url::toRouter('AdminAdminIndex'));

    return $this->view->with('form', $form);
  }
  
  public function create() {
    wtfTo('AdminAdminAdd');

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
      Validator::need($params, 'account', '帳號')->isVarchar(190);
      Validator::need($params, 'password', '密碼')->isPassword();
      Validator::need($params, 'roles', '角色')->filter(array_keys(\M\AdminRole::ROLE));
      $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
    });

    transaction(function() use (&$params) {
      if (!$obj = \M\Admin::create($params))
        return false;

      // roles
      foreach ($params['roles'] as $role)
        if (!\M\AdminRole::create(['adminId' => $obj->id, 'role' => $role]))
          return false;

      return true;
    });


    Url::refreshWithSuccessFlash(Url::toRouter('AdminAdminIndex'), '新增成功！');
  }
  
  public function edit() {
    $form = AdminForm::create($this->obj)
                     ->setActionUrl(Url::toRouter('AdminAdminUpdate', $this->obj))
                     ->setBackUrl(Url::toRouter('AdminAdminIndex'));

    return $this->view->with('form', $form);
  }
  
  public function update() {
    wtfTo('AdminAdminEdit', $this->obj);

    $params = Input::post();
    
    validator(function() use (&$params) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
      Validator::need($params, 'account', '帳號')->isVarchar(190);
      Validator::need($params, 'password', '密碼')->isPassword();
      Validator::need($params, 'roles', '角色')->filter(array_keys(\M\AdminRole::ROLE));
      
      $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
    });

    transaction(function() use (&$params) {
      if (!($this->obj->columnsUpdate($params) && $this->obj->save()))
        return false;

      // tags
      $oris = arrayColumn($this->obj->roles, 'role');
      $dels = array_diff($oris, $params['roles']);
      $adds = array_diff($params['roles'], $oris);

      foreach ($dels as $del)
        if ($role = \M\AdminRole::one('adminId = ? AND role = ?', $this->obj->id, $del))
          if (!$role->delete())
            return false;

      foreach ($adds as $add)
        if (!\M\AdminRole::create(['adminId' => $this->obj->id, 'role' => $add]))
          return false;

      return true;
    });
    
    Url::refreshWithSuccessFlash(Url::toRouter('AdminAdminIndex'), '修改成功！');
  }
  
  public function show() {
    $show = AdminShow::create($this->obj)
                     ->setBackUrl(Url::toRouter('AdminAdminIndex'), '回列表');

    return $this->view->with('show', $show);
  }
  
  public function delete() {
    wtfTo('AdminAdminIndex');
    
    transaction(function() {
      return $this->obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminAdminIndex'), '刪除成功！');
  }
}
