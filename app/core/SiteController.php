<?php defined('MAPLE') || exit('此檔案不允許讀取！');

abstract class SiteController extends Controller {
  protected $asset, $view;
  public $flash;
  
  public function __construct() {
    parent::__construct();

    Load::sysLib('Asset.php');
    Load::sysLib('Session.php');
    Load::sysLib('Validator.php');
    Load::sysLib('Html.php');

    $this->asset = Asset::create(1)
         ->addCSS('/asset/css/icon-site.css')
         ->addCSS('/asset/css/site/layout.css')
         ->addJS('/asset/js/res/jquery-1.10.2.min.js')
         ->addJS('/asset/js/site/layout.js');

    $this->flash = Session::getFlashData('flash');
    !isset($this->flash['params']) || $this->flash['params'] || $this->flash['params'] = null;

    $this->view = View::maybe('site/' . Router::className() . '/' . Router::methodName() . '.php')
                      ->appendTo(View::create('site/layout.php'), 'content')
                      ->with('flash', $this->flash)
                      ->withReference('asset', $this->asset);
  }
}
