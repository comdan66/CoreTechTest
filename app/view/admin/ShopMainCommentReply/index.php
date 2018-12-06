<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminListSearchInput as SearchInput;
use AdminListSearchCheckbox as SearchCheckbox;

use AdminListText as ListText;
use AdminListCtrl as ListCtrl;

echo $show->back();

echo $list->search(function() {

  SearchInput::create('ID')
    ->sql('id = ?');

  SearchInput::create('名稱')
    ->sql('name LIKE ?');

  SearchInput::create('內文')
    ->sql('content LIKE ?');
});

echo $list->table(function($obj) use ($grand, $parent) {
  
  ListText::create('ID')
    ->content($obj->id)
    ->width(60)
    ->order('id');

  ListText::create('名稱')
    ->content($obj->name)
    ->width(120);

  ListText::create('內文')
    ->content(minText($obj->content));

  ListCtrl::create()
    ->addShow('AdminShopMainCommentReplyShow', $grand, $parent, $obj)
    ->addDelete('AdminShopMainCommentReplyDelete', $grand, $parent, $obj);
});

echo $list->pages();
