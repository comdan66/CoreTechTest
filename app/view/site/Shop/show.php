<header>
  <h2><?php echo $shopMain->name;?></h2>
  <div>
    <a class='go-comment' href='<?php echo Url::toRouter('ShopCommentIndex', $shopMain);?>'>分享文</a>
    <label class='like' data-id='<?php echo $shopMain->id;?>'>like</label>
  </div>
</header>

<article>
  <b><?php echo $shopMain->title;?></b>
  <p><?php echo $shopMain->text;?></p>
</article>

<h3 class='icon-7'>Photo galley</h3>
<div id='banner' class='banner' data-unit='1' data-page='1' data-point='on' data-arrow='on' data-auto='0'>
  <div class='items'>
<?php
    foreach ($shopMain->photos as $photo) { ?>
      <div class='item' data-bgurl='<?php echo $photo->filename->url('w700');?>'></div>
    <?php
    } ?>
  </div>

</div>


<h3 class='icon-8'>Access</h3>
<div id='maps'>
  <div class="map"data-lat='<?php echo $shopMain->latitude;?>' data-lng='<?php echo $shopMain->longitude;?>'></div>
  <div class="zoom">
    <label class="icon-14"></label>
    <label class="icon-13"></label>
  </div>
</div>

<h3 class='icon-9'>Imformation</h3>
<div id='table'>
  <div class='tr' data-title='商家名稱'><span><?php echo $shopMain->name;?></span></div>
  <div class='tr' data-title='商家分類'><span><?php echo $shopMain->foodMain->name;?></span></div>
  <div class='tr' data-title='標籤'><span><?php echo implode(' / ', array_map(function($food) { return $food->name; }, $shopMain->foods));?></span></div>
  <div class='tr' data-title='電話'><span><?php echo $shopMain->tel;?></span></div>
  <div class='tr' data-title='地址'><span><?php echo $shopMain->address;?></span></div>
  <div class='tr' data-title='捷運資訊'><span><?php echo $shopMain->station;?></span></div>
  <div class='tr' data-title='公休日'><span><?php echo $shopMain->holiday;?></span></div>
  <div class='tr' data-title='營業時間'><span><?php echo $shopMain->openTime;?></span></div>
  <div class='tr' data-title='營業資訊'><span><?php echo $shopMain->info;?></span></div>
  <div class='tr' data-title='更新時間'><span><?php echo $shopMain->updateAt->format('Y/m/d');?></span></div>
</div>
