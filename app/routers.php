<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::get('')->controller('Main@index');

Router::get('shops')->controller('Shop@index');
Router::get('shops/(id:num)')->controller('Shop@show');
Router::get('shops/top')->controller('Shop@top');
Router::get('shops/search')->controller('Shop@search');
Router::get('shops/(id:num)/comments')->controller('ShopComment@index');
Router::post('shops/(id:num)/comments')->controller('ShopComment@create');

Router::file('cli.php')   || gg('載入 Router「cli.php」失敗！');
Router::file('admin.php') || gg('載入 Router「admin.php」失敗！');
Router::file('api.php')   || gg('載入 Router「api.php」失敗！');
