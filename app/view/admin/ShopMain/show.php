<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminShowText as ShowText;
use AdminShowTextarea as ShowTextarea;
use AdminShowItems as ShowItems;
use AdminShowLatlng as ShowLatlng;
use AdminShowImages as ShowImages;

echo $show->back();

echo $show->panel(function($obj, &$title) {
  ShowText::create('ID')
    ->content($obj->id);

  ShowText::create('名稱')
    ->content($obj->name);

  ShowText::create('標題')
    ->content($obj->title);

  ShowText::create('電話')
    ->content($obj->tel);

  ShowTextarea::create('內文')
    ->content($obj->text);
});

echo $show->panel(function($obj, &$title) {
  $title = '互動資訊';

  ShowText::create('分數')
    ->content(number_format($obj->score, 2));
});

echo $show->panel(function($obj, &$title) {
  $title = '分類資訊';

  ShowText::create('縣市')
    ->content($obj->areaMain->name);

  ShowText::create('市區')
    ->content($obj->areaSub->name);

  ShowText::create('分類')
    ->content($obj->foodMain->name);

  ShowItems::create('標籤')
    ->content(arrayColumn($obj->foods, 'name'));

  ShowImages::create('照片')
    ->content(array_column($obj->photos, 'filename'));
});

echo $show->panel(function($obj, &$title) {
  $title = '營業資訊';

    
  ShowTextarea::create('休假日')
    ->content($obj->holiday);

  ShowTextarea::create('營業時間')
    ->content($obj->openTime);
    
  ShowTextarea::create('資訊')
    ->content($obj->info);
});

echo $show->panel(function($obj, &$title) {
  $title = '位置資訊';

  ShowTextarea::create('捷運站')
    ->content($obj->station);

  ShowText::create('地址')
    ->content($obj->address);

  ShowLatlng::create('經緯度')
    ->content($obj->latitude, $obj->longitude);
});

echo $show->panel(function($obj, &$title) {
  $title = '其他資訊';

  ShowText::create('上次更新時間')
    ->content($obj->updateAt);

  ShowText::create('新增時間')
    ->content($obj->createAt);
});
