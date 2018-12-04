<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Task extends CrontabController {

  public function photo() {
    $photos = \M\ShopPhoto::all();
    foreach ($photos as $photo) {
      echo $photo->id . ' => ' . ($t = 'http://dev.core-tech.ioa.tw/tmp/shop/' . $photo->photoNum . '.png') . ' => ';
      echo $photo->filename->putUrl($t) ? 'ok' : 'no';
      echo "\n";
    }
  }
}
