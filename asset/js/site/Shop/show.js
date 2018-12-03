$(function () {
  
  $('.banner').each(function() {
    var $that = $(this);

    // 取得 unit，沒有給預設 1
    var unit = $that.data('unit');
    unit = unit ? unit : 1;
    $that.attr('data-unit', unit);

    // 取得 page，沒有給預設 1
    var page = $that.data('page');
    page = page ? page : 1;
    $that.attr('data-page', page);

    // 取得 auto，沒有給預設 0
    var auto = $that.data('auto');
    auto = auto ? auto : 0;
    $that.attr('data-auto', auto);

    // 頁數
    var pageCount = Math.ceil($that.find('.item').length / unit);

    var setDataPage = function(n) {
      var p = parseInt($that.attr('data-page'), 10) + (n && $(this).hasClass('left') ? -1 : 1);
      p = p > pageCount ? 1 : p;
      p = p < 1 ? pageCount : p;
      $that.attr('data-page', p);
    };

    // 定義箭頭
    var arrow = $that.data('arrow');
    if (arrow && arrow.toLowerCase() == 'on') {

      // 在這邊設定左右按鈕的內容
      var $arrows = [
        $('<a />').addClass('left'),
        $('<a />').addClass('right')];

      $arrows = $($arrows).map($.fn.toArray).click(setDataPage);

      $that.append(
        $arrows);
    }

    // 定義小點點
    var point = $that.data('point');
    if (point && point.toLowerCase() == 'on') {
      // 處理每個點
      var $points = [];
      for (var i = 0; i < pageCount; i++)
        $points.push($('<label />'));

      $points = $($points).map($.fn.toArray).click(function() {
        $that.attr('data-page', $(this).index() + 1);
      });

      $that.append(
        $('<div />').addClass('pages').append(
          $('<div />').append(
            $points)));

      $points.eq(page - 1)
            .click();
    }

    // 定義輪播
    if (auto)
      setInterval(setDataPage, auto);

  });

});