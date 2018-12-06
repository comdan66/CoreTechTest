<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminShowText as ShowText;
use AdminShowTextarea as ShowTextarea;

echo $show->back();

echo $show->panel(function($obj, &$title) {
  ShowText::create('ID')
    ->content($obj->id);

  ShowText::create('名稱')
    ->content($obj->name);

  ShowTextarea::create('內文')
    ->content($obj->content);

  ShowText::create('上次更新時間')
    ->content($obj->updateAt);

  ShowText::create('新增時間')
    ->content($obj->createAt);
});
