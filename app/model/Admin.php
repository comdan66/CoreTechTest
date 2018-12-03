<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class Admin extends Model {
  // static $hasOne = [];

  static $hasMany = [
    'roles' => 'AdminRole',
  ];

  // static $belongToOne = [];

  // static $belongToMany = [];

  // static $uploaders = [];

  public function inRoles() {
    foreach (func_get_args() as $arg)
      if (in_array($arg, arrayColumn($this->roles, 'role')))
        return true;

    return false;
  }
  public static function current() {
    return \Session::getData('admin');
  }
}
