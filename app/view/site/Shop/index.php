<div class='left'>
  <h2><?php echo $tag;?></h2>
  <?php
  if ($page['links']) { ?>
    <div class='pagination'>
      <div>
  <?php echo $page['links'] = implode('', $page['links']);?>
      </div>
    </div>
  <?php
  } ?>

  <div class='items red'>
<?php
    foreach ($shopMains as $i => $shopMain) { ?>
      <div class='item'>
        <a class='title' href='' data-rank='<?php echo $page['offset'] + $i + 1;?>'>
          <span><?php echo $shopMain->name;?></span>
        </a>
        
        <div class='detail'>
          <div class='img'>
            <img src='<?php echo $shopMain->photos ? $shopMain->photos[0]->filename->url('w330') : '';?>'>
          </div>

          <div class='infos'>
            <span class='title'><?php echo $shopMain->title;?></span>
            <div class='table'>
              <div data-title='分類'>
                <span><?php echo !$shopMain->foodMain ? $shopMain->foodMain->name : '';?></span>
              </div>
              <div data-title='標籤'>
                <span><?php echo implode('', array_map(function($food) { return '<a>' . $food->name . '</a>'; }, $shopMain->foods));?></span>
              </div>
              <div data-title='營業時間'>
                <span><?php echo $shopMain->openTime;?></span>
              </div>
              <div data-title='地址'>
                <span><?php echo $shopMain->address;?></span>
              </div>
            </div>

            <label class='like' data-id='<?php echo $shopMain->id;?>'>like</label>
          </div>

        </div>
      </div>
<?php
    } ?>
  </div>

  <?php
  if ($page['links']) { ?>
    <div class='pagination'>
      <div>
  <?php echo $page['links'];?>
      </div>
    </div>
  <?php
  } ?>

</div>

<form class='right'>
  <div class='title'>查詢</div>
  
  <div class='condition red'>
    <div class='title'>地點</div>
<?php
    foreach ($area as $main) { ?>
      <span<?php echo attr($main, ['subs', 'text']);?>><?php echo $main['text'];?></span>
<?php if ($main['subs']) { ?>
        <div>
    <?php foreach ($main['subs'] as $sub) { ?>
            <label>
              <input<?php echo attr($sub, 'text');?>>
              <span><?php echo $sub['text'];?></span>
            </label>
    <?php }?>
        </div>
<?php }
    } ?>
  </div>
  
  <div class='condition yellow'>
    <div class='title'>分類</div>
<?php
    foreach ($food as $main) { ?>
      <span<?php echo attr($main, ['subs', 'text']);?>><?php echo $main['text'];?></span>
<?php if ($main['subs']) { ?>
        <div>
    <?php foreach ($main['subs'] as $sub) { ?>
            <label>
              <input<?php echo attr($sub, 'text');?>>
              <span><?php echo $sub['text'];?></span>
            </label>
    <?php }?>
        </div>
<?php }
    } ?>
  </div>

  <div class='btns'>
    <input type='submit' value='查詢'>
    <a href="<?php echo Url::toRouter('ShopIndex');?>">排行榜</a>
  </div>
</form>