<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::get('shops')->controller('Shop@index');
Router::get('shops/search')->controller('Shop@search');
Router::get('shops/(id:num)')->controller('Shop@show');

Router::get('shops/(id:num)/comments')->controller('ShopComment@index');
Router::post('shops/(id:num)/comments')->controller('ShopComment@create');
