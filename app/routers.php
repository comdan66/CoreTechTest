<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::get('')->controller('Main@index');

Router::file('cli.php')   || gg('載入 Router「cli.php」失敗！');
Router::file('admin.php') || gg('載入 Router「admin.php」失敗！');
Router::file('api.php')   || gg('載入 Router「api.php」失敗！');
Router::file('site.php')   || gg('載入 Router「site.php」失敗！');
