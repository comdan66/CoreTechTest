<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminListSearchInput as SearchInput;
use AdminListSearchCheckbox as SearchCheckbox;

use AdminListText as ListText;
use AdminListCtrl as ListCtrl;
use AdminListImages as ListImages;

echo $list->search(function() {

  SearchInput::create('ID')
    ->sql('id = ?');

  SearchInput::create('名稱')
    ->sql('name LIKE ?');

  SearchInput::create('標題')
    ->sql('title LIKE ?');

  SearchInput::create('內文')
    ->sql('text LIKE ?');

  SearchInput::create('電話')
    ->sql('tel LIKE ?');

  SearchInput::create('地址')
    ->sql('address LIKE ?');

});

echo $list->table(function($obj) {
  
  ListText::create('ID')
    ->content($obj->id)
    ->width(60)
    ->order('id');

  ListImages::create('頭像')
    ->content(array_column($obj->photos, 'filename'));

  ListText::create('名稱')
    ->content($obj->name)
    ->width(120);

  ListText::create('標題')
    ->content($obj->title);

  ListText::create('分數')
    ->content(number_format($obj->score, 2))
    ->width(100)
    ->order('score');

  ListCtrl::create()
    ->addShow('AdminShopMainShow', $obj)
    ->addEdit('AdminShopMainEdit', $obj)
    ->addDelete('AdminShopMainDelete', $obj);
});

echo $list->pages();
