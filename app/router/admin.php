<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::dir('admin', 'Admin', function() {

  // 登入
  Router::get('logout')->controller('Auth@logout');
  Router::get('login')->controller('Auth@login');
  Router::post('login')->controller('Auth@signin');

  // 後台主頁
  Router::get()->controller('Main@index');
  Router::post('theme')->controller('Main@theme');

  // Admin
  Router::get('admins')->controller('Admin@index');
  Router::get('admins/add')->controller('Admin@add');
  Router::post('admins')->controller('Admin@create');
  Router::get('admins/(id:num)/edit')->controller('Admin@edit');
  Router::put('admins/(id:num)')->controller('Admin@update');
  Router::get('admins/(id:num)')->controller('Admin@show');
  Router::del('admins/(id:num)')->controller('Admin@delete');
  
  // Backup
  Router::get('backups')->controller('Backup@index');
  Router::get('backups/(id:num)')->controller('Backup@show');
  Router::post('backups/(id:num)/read')->controller('Backup@read');

  // Crontab
  Router::get('crontabs')->controller('Crontab@index');
  Router::get('crontabs/(id:num)')->controller('Crontab@show');
  Router::post('crontabs/(id:num)/read')->controller('Crontab@read');

  // Shop
  Router::get('shops')->controller('ShopMain@index');
  Router::get('shops/add')->controller('ShopMain@add');
  Router::post('shops')->controller('ShopMain@create');
  Router::get('shops/(id:num)/edit')->controller('ShopMain@edit');
  Router::put('shops/(id:num)')->controller('ShopMain@update');
  Router::get('shops/(id:num)')->controller('ShopMain@show');
  Router::del('shops/(id:num)')->controller('ShopMain@delete');

  // AreaMain
  Router::get('area-mains')->controller('AreaMain@index');
  Router::get('area-mains/add')->controller('AreaMain@add');
  Router::post('area-mains')->controller('AreaMain@create');
  Router::get('area-mains/(id:num)/edit')->controller('AreaMain@edit');
  Router::put('area-mains/(id:num)')->controller('AreaMain@update');
  Router::del('area-mains/(id:num)')->controller('AreaMain@delete');
  Router::post('area-mains/sort')->controller('AreaMain@sort');

  // AreaSub
  Router::get('area-mains/(mainId:num)/area-subs')->controller('AreaSub@index');
  Router::get('area-mains/(mainId:num)/area-subs/add')->controller('AreaSub@add');
  Router::post('area-mains/(mainId:num)/area-subs')->controller('AreaSub@create');
  Router::get('area-mains/(mainId:num)/area-subs/(id:num)/edit')->controller('AreaSub@edit');
  Router::put('area-mains/(mainId:num)/area-subs/(id:num)')->controller('AreaSub@update');
  Router::del('area-mains/(mainId:num)/area-subs/(id:num)')->controller('AreaSub@delete');
  Router::post('area-mains/(mainId:num)/area-subs/sort')->controller('AreaSub@sort');

  
  // FoodMain
  Router::get('food-mains')->controller('FoodMain@index');
  Router::get('food-mains/add')->controller('FoodMain@add');
  Router::post('food-mains')->controller('FoodMain@create');
  Router::get('food-mains/(id:num)/edit')->controller('FoodMain@edit');
  Router::put('food-mains/(id:num)')->controller('FoodMain@update');
  Router::del('food-mains/(id:num)')->controller('FoodMain@delete');
  Router::post('food-mains/sort')->controller('FoodMain@sort');

  // FoodSub
  Router::get('food-mains/(mainId:num)/food-subs')->controller('FoodSub@index');
  Router::get('food-mains/(mainId:num)/food-subs/add')->controller('FoodSub@add');
  Router::post('food-mains/(mainId:num)/food-subs')->controller('FoodSub@create');
  Router::get('food-mains/(mainId:num)/food-subs/(id:num)/edit')->controller('FoodSub@edit');
  Router::put('food-mains/(mainId:num)/food-subs/(id:num)')->controller('FoodSub@update');
  Router::del('food-mains/(mainId:num)/food-subs/(id:num)')->controller('FoodSub@delete');
  Router::post('food-mains/(mainId:num)/food-subs/sort')->controller('FoodSub@sort');

  
});