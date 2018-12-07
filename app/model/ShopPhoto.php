<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopPhoto extends Model {
  // static $hasOne = [];

  // static $hasMany = [];

  // static $belongToOne = [];

  // static $belongToMany = [];

  static $uploaders = [
    'filename' => 'ShopPhotoFilenameImageUploader',
  ];

  public function putFiles($files) {
    foreach ($files as $key => $file)
      if ($file && isset($this->$key) && $this->$key instanceof Uploader && !$this->$key->put($file))
        return false;
    return true;
  }
}

class ShopPhotoFilenameImageUploader extends ImageUploader {
  public function versions() {
    return [
      'w330' => ['resize' => [330, 330, 'width']],
      'w700' => ['resize' => [700, 700, 'width']],
    ];
  }
}
