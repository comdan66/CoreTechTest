<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::dir('cli', function() {
  Router::cli('crontab/backup/db')->controller('Crontab@backupDb');
  Router::cli('crontab/backup/logs/(beforeDay:num)')->controller('Crontab@backupLogs');
  Router::cli('task/photo')->controller('Task@photo');
});
