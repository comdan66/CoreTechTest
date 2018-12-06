$(function() {
  $('.right .condition span').each(function() {
    var $that = $(this);
    var $checkbox = $that.next('div').find('input[type="checkbox"]');
    
    $that.click(function() {
      if (!$that.toggleClass('active').hasClass('active'))
        $checkbox.prop('checked', false);
    });

    $checkbox.first().click(function() {
      $checkbox.prop('checked', $(this).prop('checked'));
    });
  });
  
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
  
  window.fns = {};

  window.fns.Storage = {
    init: function () { return typeof Storage !== 'undefined'; },
    set: function (k, d) { try { if (!window.fns.Storage.init ()) return false; localStorage.setItem (k, JSON.stringify (d)); return true; } catch (err) { console.error ('設定 storage 失敗！', error); return false; } },
    get: function (k) { return window.fns.Storage.init () && (value = localStorage.getItem (k)) && (value = JSON.parse (value)) ? value : undefined; },
  };

  window.fns.Like = {
    key: 'core-tech.likes',
    ttl: 31536000 * 1000, // 一年
    get: function() {
      var datas = window.fns.Storage.get(this.key);
      return datas && typeof datas === 'object' ? datas.filter(function(t) { return typeof t.id !== 'undefined' && typeof t.time !== 'undefined' && t.time + window.fns.Like.ttl > new Date().getTime(); }) : [];
    },
    set: function(datas) {
      window.fns.Storage.set(window.fns.Like.key, datas);
    },
    has: function(id) {
      return window.fns.Like.get().filter(function(t) { return t.id == id; }).length ? true : false;
    },
    add: function(id) {
      window.fns.Like.del(id);
      var datas = window.fns.Like.get();
      datas.push({id: id, time: new Date().getTime()});
      window.fns.Like.set(datas);
    },
    del: function(id) {
      window.fns.Like.set(window.fns.Like.get().filter(function(t) {
        return t.id != id;
      }));
    }
  };

  $('.like[data-id]').each(function() {
    if (window.fns.Like.has($(this).data('id')))
      $(this).addClass('ed');

    $(this).click(function() {
      if ($(this).toggleClass('ed').hasClass('ed'))
        window.fns.Like.add($(this).data('id'));
      else
        window.fns.Like.del($(this).data('id'));
    });
  });
});