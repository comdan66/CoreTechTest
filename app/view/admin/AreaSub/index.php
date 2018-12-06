<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminListSearchInput as SearchInput;

use AdminListText as ListText;
use AdminListCtrl as ListCtrl;

echo $show->back();

echo $list->search(function() {

  SearchInput::create('ID')
    ->sql('id = ?');

  SearchInput::create('名稱')
    ->sql('name LIKE ?');
});

echo $list->table(function($obj) use ($parent) {
  
  ListText::create('ID')
    ->content($obj->id)
    ->width(60)
    ->order('id');

  ListText::create('名稱')
    ->content($obj->name);

  ListText::create('新增時間')
    ->content($obj->createAt)
    ->width(150);

  ListCtrl::create()
    ->addEdit('AdminAreaSubEdit', $parent, $obj);
});

echo $list->pages();