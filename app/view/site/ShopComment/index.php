<div class='top'>
  <h2>TEST1日式小小居酒屋</h2>
  <a href="<?php echo Url::toRouter('ShopShow', $shop);?>">回店家首頁</a>
</div>

<h3 class='icon-10'>Comment</h3>

<div class='left'>
  
  <?php
  if ($page['links']) { ?>
    <div class='pagination'>
      <div>
  <?php echo $page['links'] = implode('', $page['links']);?>
      </div>
    </div>
  <?php
  } ?>

  <div class='comments'><?php
    foreach ($comments as $comment) {
      $replies = array_map(function($reply) {
        return [
          'id' => $reply->id,
          'name' => $reply->name,
          'content' => $reply->content,
          'createAt' => $reply->createAt->format('Y/m/d H:i'),
        ];
      }, \M\ShopMainCommentReply::all(['order' => 'id DESC', 'limit' => 3, 'where' => ['shopMainId = ? AND shopMainCommentId = ?', $shop->id, $comment->id]])); ?>
      <div class='comment'>
        <b class='title'><?php echo $comment->title;?></b>
        <div class='info'><b><?php echo $comment->name;?></b><time><?php echo $comment->createAt->format('Y/m/d H:i');?></time></div>
        <div class='score'><?php echo number_format($comment->score);?></div>
        <div class='content'><?php echo $comment->content;?></div>

        <div class='replies' data-d4='<?php echo json_encode($replies);?>' data-url='<?php echo Url::toRouter('ApiShopCommentReplyIndex', $shop, $comment);?>'></div>

        <form class='reply' method='post' action='<?php echo Url::toRouter('ApiShopCommentReplyCreate', $shop, $comment);?>'>
          <span></span>
          <div class='row' data-title='name'><input type='text' placeholder="請寫您的名字" required name='name'></div>
          <div class='row' data-title='message'><textarea placeholder="請寫回應" required name='content'></textarea></div>
          <div class='row'>
            <input type='submit' value='送出'>
            <input type='reset' value='重填'>
          </div>
        </form>
      </div>
    <?php
    }
    ?></div>

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
<form class='right' method='post' action='<?php echo Url::toRouter('ShopCommentCreate', $shop);?>'>
  <b>投稿</b>
  <span class='<?php echo $flash['type'];?>'><?php echo $flash['msg'];?></span>
  <div data-title='name'><input type='text' name='name' placeholder="請寫您的名字" required value='<?php echo $flash['params']['name'] ?: '';?>'></div>
  <div data-title='score' class='score'><input type='number' name='score' placeholder="請寫評分" required value='<?php echo $flash['params']['score'] ?: '';?>'></div>
  <div data-title='title'><input type='text' name='title' placeholder="請寫標題" required value='<?php echo $flash['params']['title'] ?: '';?>'></div>
  <div data-title='comment'><textarea name='content' placeholder="請寫分享文" required><?php echo $flash['params']['content'] ?: '';?></textarea></div>
  <div class='btns'>
    <input type='submit' value='投稿'>
  </div>
</form>
