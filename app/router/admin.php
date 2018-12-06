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

  // Shop Comment
  Router::get('shops/(shopId:num)/comments')->controller('ShopMainComment@index');
  Router::get('shops/(shopId:num)/comments/(id:num)')->controller('ShopMainComment@show');
  Router::del('shops/(shopId:num)/comments/(id:num)')->controller('ShopMainComment@delete');

  // Shop Comment Reply
  Router::get('shops/(shopId:num)/comments/(commentId:num)/replies')->controller('ShopMainCommentReply@index');
  Router::get('shops/(shopId:num)/comments/(commentId:num)/replies/(id:num)')->controller('ShopMainCommentReply@show');
  Router::del('shops/(shopId:num)/comments/(commentId:num)/replies/(id:num)')->controller('ShopMainCommentReply@delete');

  // AreaMain
  Router::get('areas')->controller('AreaMain@index');
  Router::get('areas/add')->controller('AreaMain@add');
  Router::post('areas')->controller('AreaMain@create');
  Router::get('areas/(id:num)/edit')->controller('AreaMain@edit');
  Router::put('areas/(id:num)')->controller('AreaMain@update');
  Router::del('areas/(id:num)')->controller('AreaMain@delete');
  Router::post('areas/sort')->controller('AreaMain@sort');

  // AreaSub
  Router::get('areas/(mainId:num)/area-subs')->controller('AreaSub@index');
  Router::get('areas/(mainId:num)/area-subs/add')->controller('AreaSub@add');
  Router::post('areas/(mainId:num)/area-subs')->controller('AreaSub@create');
  Router::get('areas/(mainId:num)/area-subs/(id:num)/edit')->controller('AreaSub@edit');
  Router::put('areas/(mainId:num)/area-subs/(id:num)')->controller('AreaSub@update');
  Router::del('areas/(mainId:num)/area-subs/(id:num)')->controller('AreaSub@delete');
  Router::post('areas/(mainId:num)/area-subs/sort')->controller('AreaSub@sort');

  
  // FoodMain
  Router::get('foods')->controller('FoodMain@index');
  Router::get('foods/add')->controller('FoodMain@add');
  Router::post('foods')->controller('FoodMain@create');
  Router::get('foods/(id:num)/edit')->controller('FoodMain@edit');
  Router::put('foods/(id:num)')->controller('FoodMain@update');
  Router::del('foods/(id:num)')->controller('FoodMain@delete');
  Router::post('foods/sort')->controller('FoodMain@sort');

  // FoodSub
  Router::get('foods/(mainId:num)/food-subs')->controller('FoodSub@index');
  Router::get('foods/(mainId:num)/food-subs/add')->controller('FoodSub@add');
  Router::post('foods/(mainId:num)/food-subs')->controller('FoodSub@create');
  Router::get('foods/(mainId:num)/food-subs/(id:num)/edit')->controller('FoodSub@edit');
  Router::put('foods/(mainId:num)/food-subs/(id:num)')->controller('FoodSub@update');
  Router::del('foods/(mainId:num)/food-subs/(id:num)')->controller('FoodSub@delete');
  Router::post('foods/(mainId:num)/food-subs/sort')->controller('FoodSub@sort');

  
});