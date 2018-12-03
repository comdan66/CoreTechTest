<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

    <title><?php echo isset($title) && $title ? (is_array($title) ? $title[0] : $title) . ' | ' : '';?>後台系統</title>

    <?php echo $asset->renderCSS();?>
    <?php echo $asset->renderJS();?>

  </head>
  <body lang="zh-tw">

    <main id='main'>
      <header id='main-header'>
        <a id='hamburger' class='icon-01'></a>
        <nav>
    <?php echo isset($title) && $title ? is_array($title) ? implode('', array_map(function($text) { return '<b>' . $text . '</b>'; }, $title)) : '<b>' . $title . '</b>' : '';?>
          <label>
            <select id='theme' data-url='<?php echo Url::toRouter('AdminMainTheme');?>'>
              <option value='blue'<?php echo $theme === 'blue' ? ' selected' : '';?>>藍色 主題</option>
              <option value='green'<?php echo $theme === 'green' ? ' selected' : '';?>>綠色 主題</option>
            </select>
          </label>
        </nav>
        <a href='<?php echo Url::toRouter('AdminAuthLogout');?>' class='icon-02'></a>
      </header>

      <div class='flash <?php echo $flash['type'];?>'><?php echo $flash['msg'];?></div>

      <div id='container'><?php echo isset($content) ? $content : ''; ?></div>

    </main>

    <div id='menu'>
      <header id='menu-header'>
        <a href='<?php echo Url::base();?>' class='icon-21'></a>
        <span>後台系統</span>
      </header>

      <div id='menu-user'>
        <figure class='_ic'>
          <img src="<?php echo Asset::url('asset/img/admin.png');?>">
        </figure>

        <div>
          <span>Hi, 您好!</span>
          <b><?php echo \M\Admin::current()->name;?></b>
        </div>
      </div>

      <div id='menu-main'>
        <div>
    <?php if (\M\Admin::current()->inRoles(\M\AdminRole::ROLE_ROOT)) {
            $bcnt = \M\Backup::count('isRead = ?', \M\Backup::IS_READ_NO);
            $ccnt = \M\Crontab::count('isRead = ?', \M\Crontab::IS_READ_NO); ?>
            <span data-cntlabel='backup-isRead crontab-isRead' data-cnt='<?php echo $bcnt + $ccnt;?>' class='icon-14'>後台設定</span>
            <div>
              <a href="<?php echo $url = Url::toRouter('AdminMainIndex');?>" class='icon-21<?php echo $url === $currentUrl ? ' active' : '';?>'>後台首頁</a>
              <a href="<?php echo $url = Url::toRouter('AdminAdminIndex');?>" class='icon-15<?php echo $url === $currentUrl ? ' active' : '';?>'>管理員帳號</a>
              <a href="<?php echo $url = Url::toRouter('AdminBackupIndex');?>" class='icon-46<?php echo $url === $currentUrl ? ' active' : '';?>' data-cntlabel='backup-isRead' data-cnt='<?php echo $bcnt;?>'>每日備份</a>
              <a href="<?php echo $url = Url::toRouter('AdminCrontabIndex');?>" class='icon-62<?php echo $url === $currentUrl ? ' active' : '';?>' data-cntlabel='crontab-isRead' data-cnt='<?php echo $ccnt;?>'>排程執行</a>
            </div>
    <?php } else if (\M\Admin::current()->inRoles(\M\AdminRole::ROLE_ADMIN)) { ?>
            <span class='icon-14'>後台設定</span>
            <div>
              <a href="<?php echo $url = Url::toRouter('AdminMainIndex');?>" class='icon-21<?php echo $url === $currentUrl ? ' active' : '';?>'>後台首頁</a>
              <a href="<?php echo $url = Url::toRouter('AdminAdminIndex');?>" class='icon-15<?php echo $url === $currentUrl ? ' active' : '';?>'>管理員帳號</a>
            </div>
    <?php } else { ?>
            <span class='icon-14'>後台設定</span>
            <div>
              <a href="<?php echo $url = Url::toRouter('AdminMainIndex');?>" class='icon-21<?php echo $url === $currentUrl ? ' active' : '';?>'>後台首頁</a>
            </div>
    <?php } ?>
        </div>

      </div>
    </div>


    <footer id='footer'><span>後台版型設計 by </span><a href='https://www.ioa.tw/' target='_blank'>OAWU</a></footer>

  </body>
</html>
