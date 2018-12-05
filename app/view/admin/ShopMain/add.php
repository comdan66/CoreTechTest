<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminFormInput as FormInput;
use AdminFormTextarea as FormTextarea;
use AdminFormImages as FormImages;
use AdminFormSelect as FormSelect;
use AdminFormCheckbox as FormCheckbox;
use AdminFormLatlng as FormLatlng;

echo $form->back();

echo $form->form(function() {
  FormInput::create('名稱', 'name')
    ->need()
    ->placeholder('請輸入商店名稱..')
    ->focus();

  FormInput::create('標題', 'title')
    ->need()
    ->placeholder('請輸入商店標題..');

  FormImages::create('照片', 'images')
    ->accept('image/*')
    ->need();

  FormTextarea::create('內文', 'text')
    ->placeholder('請輸入商店介紹..')
    ->need();

  $areaMains = \M\AreaMain::arr(['id', 'name'], ['order' => 'sort ASC']);

  FormSelect::create('縣市', 'areaMainId')
    ->need()
    ->className('area-main-id')
    ->items(array_combine(array_column($areaMains, 'id'), array_column($areaMains, 'name')));

  FormSelect::create('市區', 'areaSubId')
    ->need()
    ->tip('請先選擇縣市！')
    ->className('area-sub-id')
    ->items([]);

  $foodMains = \M\FoodMain::arr(['id', 'name']);

  FormSelect::create('分類', 'foodMainId')
    ->need()
    ->className('food-main-id')
    ->items(array_combine(array_column($foodMains, 'id'), array_column($foodMains, 'name')));

  FormCheckbox::create('標籤', 'foodSubIds')
    ->need()
    ->className('food-sub-id')
    ->tip('請先選擇分類！')
    ->items([]);

  FormInput::create('地址', 'address')
    ->placeholder('請輸入商店地址..')
    ->need();

  FormInput::create('電話', 'tel')
    ->tip('ex: 0987-654-321')
    ->placeholder('請輸入商店電話..')
    ->need();

  FormTextarea::create('捷運站', 'station')
    ->tip('ex: XX站附近！、從XX站走路10分鐘！！')
    ->placeholder('請輸入附近的捷運站或車站..')
    ->need();

  FormTextarea::create('休假日', 'holiday')
    ->tip('ex: 全年無休、隔週星期天公休')
    ->placeholder('請輸入休假的日期..')
    ->need();

  FormTextarea::create('營業時間', 'openTime')
    ->tip('ex: 11:00~20:00、24H')
    ->placeholder('請輸入營業時間..')
    ->need();

  FormTextarea::create('資訊', 'info')
    ->tip('ex: 可包廂、可預約、-')
    ->placeholder('請輸入其他資訊..')
    ->need();
  
  FormLatlng::create('經緯度', 'latitude', 'longitude')
    ->tip('ex: 點選地圖取得經緯度')
    ->need();

});