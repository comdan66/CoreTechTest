<?php defined('MAPLE') || exit('此檔案不允許讀取！');

abstract class AdminCrudController extends AdminController {
  protected $obj;
  
  public function __construct() {
    parent::__construct();

    Load::sysLib('Admin' . DIRECTORY_SEPARATOR . 'Admin.php');

    $this->obj = null;

    $this->view->withReference('obj', $this->obj);
  }
}
