
window.gmc = function () { $(window).trigger ('gm'); };
function OAGM(t){this._div=null,this._option=Object.assign({className:"",top:0,left:0,width:32,height:32,html:"",map:null,position:null,css:{}},t),this._option.map&&this.setMap(this._option.map)}function initOAGM(){OAGM.prototype=new google.maps.OverlayView,Object.assign(OAGM.prototype,{setPoint:function(){if(!this._option.position)return this._div.style.left="-999px",void(this._div.style.top="-999px");var t=this.getProjection().fromLatLngToDivPixel(this._option.position);t&&(this._div.style.left=t.x-this._option.width/2+this._option.left+"px",this._div.style.top=t.y-this._option.height/2+this._option.top+"px")},draw:function(){if(!this._div){for(var t in this._div=document.createElement("div"),this._div.style.position="absolute",this._div.className=this._option.className,this._div.style.width=this._option.width+"px",this._div.style.height=this._option.height+"px",this._div.innerHTML=this._option.html,this._option.css)"width"!=t&&"height"!=t&&"top"!=t&&"left"!=t&&"bottom"!=t&&"right"!=t&&(this._div.style[t]=this._option.css[t]);var i=this;google.maps.event.addDomListener(this._div,"click",function(t){t.stopPropagation&&t.stopPropagation(),google.maps.event.trigger(i,"click")}),this.getPanes().overlayImage.appendChild(this._div)}this.setPoint()},remove:function(){return this._div&&(this._div.parentNode.removeChild(this._div),this._div=null),this},setWidth:function(t){return this._div&&(this._option.width=t,this._div.style.width=this._option.width+"px",this.setPoint()),this},setHeight:function(t){return this._div&&(this._option.height=t,this._div.style.height=this._option.height+"px",this.setPoint()),this},setTop:function(t){return this._div&&(this._option.top=t,this._div.style.top=this._option.top+"px",this.setPoint()),this},setLeft:function(t){return this._div&&(this._option.left=t,this._div.style.left=this._option.left+"px",this.setPoint()),this},setHtml:function(t){return this._div&&(this._option.html=t,this._div.innerHTML=this._option.html),this},setCss:function(t){if(!this._div)return this;for(var i in this._option.css=t,this._option.css)"width"!=i&&"height"!=i&&"top"!=i&&"left"!=i&&"bottom"!=i&&"right"!=i&&(this._div.style[i]=this._option.css[i]);return this},setClassName:function(t){return this._div&&(this._option.className=t,this._div.className=this._option.className),this},getClassName:function(){return this._option.className},setPosition:function(t){return this.map&&(this._option.position=t,this.setPoint()),this},getPosition:function(){return this._option.position}})}
var OAMC=function(t){this.uses=[],this.tmp=[],this.opts=Object.assign({map:null,unit:3,useLine:!1,middle:!0,latKey:"a",lngKey:"n",varKey:null,markersKey:null},t)};Object.assign(OAMC.prototype,{clean:function(){this.uses=[],this.tmp=[]},markers:function(n){if(!this.opts.map)return[];var a=this,t=this.opts.map.zoom,e=n.length-1,s=n.length-1;n.length;for(a.clean();0<=e;e--)if(!a.uses[e])for(a.tmp[e]={m:[n[e]],a:n[e][a.opts.latKey],n:n[e][a.opts.lngKey]},a.uses[e]=!0,s=e-1;0<=s;s--)if(!a.uses[s])if(30/Math.pow(2,t)/a.opts.unit<=Math.max(Math.abs(n[e][a.opts.latKey]-n[s][a.opts.latKey]),Math.abs(n[e][a.opts.lngKey]-n[s][a.opts.lngKey]))){if(a.opts.useLine)break}else a.uses[s]=!0,a.tmp[e].m.push(n[s]);var r=[];return a.tmp.forEach(function(t,e){var s=a.opts.middle?new google.maps.LatLng(t.m.map(function(t){return t[a.opts.latKey]}).reduce(function(t,e){return t+e})/t.m.length,t.m.map(function(t){return t[a.opts.lngKey]}).reduce(function(t,e){return t+e})/t.m.length):new google.maps.LatLng(t.a,t.n);null!==a.opts.markersKey&&(s[a.opts.markersKey]=t),null!==a.opts.varKey&&(s[a.opts.varKey]=n[e]),r.push(s)}),a.clean(),r}});

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


  $('*[data-bgurl]').each(function() {
    $(this).css({'background-image': 'url(' + $(this).data('bgurl') + ')'});
  });

  window._googleMapsObj = {
    keys: [ // keys array
      'AIzaSyAPjmLZLGyiD8YRUbIctZebJwC8Vr0wSsw'
    ],
    functions: [],     // after init google maps be run functions
    isInited: false,   // is inited google maps
    isLoad: false,   // is inited google maps
    init: function() { // init google maps, and run functions
      if (window._googleMapsObj.isInited)
        return false;
      
      window._googleMapsObj.isInited = true;
      window._googleMapsObj.functions.forEach(function(t) { t(); });
    },
    appendGoogleMapsSdk: function () { // call functions
      if (window._googleMapsObj.isLoad)
        return false;
      window._googleMapsObj.isLoad = true;

      if (!window._googleMapsObj.functions.length)
        return true;

      $(window).bind('gm', window._googleMapsObj.init);

      var key = window._googleMapsObj.keys[Math.floor((Math.random() * window._googleMapsObj.keys.length))],
      script = document.createElement('script');
      script.setAttribute('type', 'text/javascript');
      script.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?' + (key ? 'key=' + key + '&' : '') + 'language=zh-TW&libraries=visualization&callback=gmc');
      (document.getElementsByTagName ('head')[0] || document.documentElement).appendChild(script);
      script.onload = window._googleMapsObj.init;

      return true;
    },
    append: function (func) { // append function
      window._googleMapsObj.functions.push(func);
      return window._googleMapsObj.appendGoogleMapsSdk;
    }
  };

  var _gmap = null;
  window._googleMapsObj.append(function() {
    if (_gmap)
      return true;

    initOAGM();

    var $maps = $('#maps');
    var $map = $maps.find('.map');
    var $zoom = $maps.find('.zoom');
    
    if (!($map.length && $zoom.length))
      return ;

    var d4Lat = 25.05;
    var d4Lng = 121.5;

    if (isNaN(parseFloat($map.data('lat'))) || isNaN(parseFloat($map.data('lng')))) {
      $lat.val(d4Lat);
      $lng.val(d4Lng);
    } else {
      d4Lat = parseFloat($map.data('lat'));
      d4Lng = parseFloat($map.data('lng'));
    }

    _gmap = new google.maps.Map($map.get(0), { zoom: 12, clickableIcons: false, disableDefaultUI: true, gestureHandling: 'greedy', center: new google.maps.LatLng (d4Lat, d4Lng) });

    $zoom.find('> *').click(function() {
      _gmap.setZoom(_gmap.zoom + ($(this).index() ? -1 : 1));
    });

    var marker = new google.maps.Marker({
      map: _gmap,
      draggable: false,
      animation: google.maps.Animation.DROP,
      position: {lat: d4Lat, lng: d4Lng}
    });

    $maps.addClass('show');
  })();

});