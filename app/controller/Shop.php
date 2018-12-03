<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Shop extends SiteController {
  public function index() {
    $this->asset
         ->addCSS('/asset/css/site/Shop/list.css')
         ->addJS('/asset/js/site/Shop/list.js');

    return $this->view;
  }

  public function search() {
    $this->asset
         ->addCSS('/asset/css/site/Shop/list.css')
         ->addJS('/asset/js/site/Shop/list.js');
    return $this->view;
  }

  public function show() {
    return $this->view;
  }
}
