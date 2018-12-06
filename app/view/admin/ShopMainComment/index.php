<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminListSearchInput as SearchInput;
use AdminListSearchCheckbox as SearchCheckbox;

use AdminListText as ListText;
use AdminListCtrl as ListCtrl;

echo $show->back();

echo $list->search(function() {

  SearchInput::create('ID')
    ->sql('id = ?');

  SearchInput::create('分數大於等於')
    ->sql('score >= ?');

  SearchInput::create('名稱')
    ->sql('name LIKE ?');

  SearchInput::create('標題')
    ->sql('title LIKE ?');

  SearchInput::create('內文')
    ->sql('content LIKE ?');
});

echo $list->table(function($obj) use ($parent) {
  
  ListText::create('ID')
    ->content($obj->id)
    ->width(60)
    ->order('id');

  ListText::create('評分')
    ->content(number_format($obj->score, 2))
    ->width(100)
    ->order('score');

  ListText::create('名稱')
    ->content($obj->name)
    ->width(120);

  ListText::create('標題')
    ->content($obj->title)
    ->width(120);

  ListText::create('內文')
    ->content(minText($obj->content));

  ListText::create('回覆數')
    ->content(Url::toRouterHyperlink('AdminShopMainCommentReplyIndex', $parent, $obj)->text(number_format(count($obj->replies)) . ' 則'))
    ->width(72);

  ListCtrl::create()
    ->addShow('AdminShopMainCommentShow', $parent, $obj)
    ->addDelete('AdminShopMainCommentDelete', $parent, $obj);
});

echo $list->pages();
