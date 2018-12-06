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
    
    <header id='header'>
      <div class='top'>
        <div class='container'>
          <h1><?php echo empty($h1) ? '' : $h1;?></h1>
        </div>
      </div>

      <div class='logo'>
        <div class='container'>
          <a href="<?php echo Url::base();?>"><img src="<?php echo Asset::url('/asset/img/site/logo.png');?>"></a>
        </div>
      </div>
    </header>

    <nav id='nav'>
      <div class='container'>
        <?php echo implode('', array_map(function($t) {
          return '<span>' . $t . '</span>';
        }, $nav));?>
      </div>
    </nav>

    <main id='main'>
      <div class='container'>
        <?php echo isset($content) ? $content : ''; ?>
      </div>
    </main>

    <footer id='footer'>
      <div class='container'>
        <a href="<?php echo Url::base();?>"><img src="<?php echo Asset::url('/asset/img/site/logo.png');?>"></a>
      </div>
    </footer>

  </body>
</html>
