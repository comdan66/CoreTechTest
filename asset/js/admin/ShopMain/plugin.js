$(function () {
  $('.area-main-id').each(function() {
    var $that = $(this);
    var $areaSubId = $that.next('.area-sub-id');

    if (!$areaSubId.length)
      return ;

    $areaSubId = $areaSubId.find('select[name="areaSubId"]');

    var $option = $areaSubId.find('option').first().clone();
    var $areaMainId = $that.find('select[name="areaMainId"]');
    var func = function() {
      $areaSubId.empty().append($option);

      if ($areaMainId.val() === "")
        return;

      $.ajax({ url: '/api/admin/areaSubId/' + $areaMainId.val(), async: true, cache: false, dataType: 'json', type: 'GET' })
       .done(function(result) {
        
        var $tmp = $(result.map(function(t) { return $('<option />').val(t.id).text(t.name); })).map($.fn.toArray);

        $areaSubId.append($tmp);

        if ($areaSubId.data('val') === "")
          return;

        $tmp.filter('[value="' + $areaSubId.data('val') + '"]').prop('selected', true);
       });
    };

    $areaMainId.change(func);

    if ($areaMainId.val() !== "")
      func();
  });

  $('.food-main-id').each(function() {
    var $that = $(this);
    var $foodSubId = $that.next('.food-sub-id');

    if (!$foodSubId.length)
      return ;

    $foodSubId = $foodSubId.find('.checkboxs');

    var $foodMainId = $that.find('select[name="foodMainId"]');
    var func = function() {

      $foodSubId.empty();

      if ($foodMainId.val() === "")
        return;

      $.ajax({ url: '/api/admin/foodSubId/' + $foodMainId.val(), async: true, cache: false, dataType: 'json', type: 'GET' })
       .done(function(result) {
        var $tmp = $(result.map(function(t) {
          return $('<label />').append(
            $('<input />').attr('type', 'checkbox').attr('name', 'foodSubIds[]').val(t.id).prop('checked', -1 != $.inArray(t.id, $foodSubId.data('val')))).append(
            $('<span />')).append(
            t.name);
        })).map($.fn.toArray);

        $foodSubId.append($tmp);
       });
    };

    $that.find('select[name="foodMainId"]').change(func);

    if ($foodMainId.val() !== "")
      func();
  });


  var _gmap = null;
  window._googleMapsObj.append(function() {
    if (_gmap)
      return true;

    initOAGM();

    var $maps = $('form.form .row .maps');
    var $map = $maps.find('.map');
    var $zoom = $maps.find('.zoom');
    var $lat = $maps.find('input[data-id="lat"]');
    var $lng = $maps.find('input[data-id="lng"]');
    
    if (!($map.length && $zoom.length && $lat.length && $lng.length))
      return ;

    var d4Lat = 25.05;
    var d4Lng = 121.5;

    if (isNaN(parseFloat($lat.val())) || isNaN(parseFloat($lng.val()))) {
      $lat.val(d4Lat);
      $lng.val(d4Lng);
    } else {
      d4Lat = parseFloat($lat.val());
      d4Lng = parseFloat($lng.val());
    }

    _gmap = new google.maps.Map($map.get(0), { zoom: 12, clickableIcons: false, disableDefaultUI: true, gestureHandling: 'greedy', center: new google.maps.LatLng (d4Lat, d4Lng) });
    _gmap.mapTypes.set('style1', new google.maps.StyledMapType([{featureType:'all',stylers:[{visibility:'on'}]},{featureType:'administrative',stylers:[{visibility:'simplified'}]},{featureType:'landscape',stylers:[{visibility:'simplified'}]},{featureType:'poi',stylers:[{visibility:'simplified'}]},{featureType:'road',stylers:[{visibility:'simplified'}]},{featureType:'road.arterial',stylers:[{visibility:'simplified'}]},{featureType:'transit',stylers:[{visibility:'simplified'}]},{featureType:'water',stylers:[{color:'#b3d1ff',visibility:'simplified'}]},{elementType:"labels.icon",stylers:[{visibility:'off'}]}]));
    _gmap.setMapTypeId('style1');

    $zoom.find('> *').click(function() {
      _gmap.setZoom(_gmap.zoom + ($(this).index() ? -1 : 1));
    });

    var marker = new google.maps.Marker({
      map: _gmap,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: {lat: d4Lat, lng: d4Lng}
    });

    marker.addListener('dragend', function() {
      $lat.val(marker.getPosition().lat());
      $lng.val(marker.getPosition().lng());
    });

    _gmap.addListener('click', function(e) {
      marker.setPosition(e.latLng);
      // _gmap.setCenter(e.latLng);
      $lat.val(e.latLng.lat());
      $lng.val(e.latLng.lng());
    });
    $maps.addClass('show');
  })();

  window._googleMapsObj.append(function() {
    if (_gmap)
      return true;

    initOAGM();

    var $maps = $('.panel .unit .maps');
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
    _gmap.mapTypes.set('style1', new google.maps.StyledMapType([{featureType:'all',stylers:[{visibility:'on'}]},{featureType:'administrative',stylers:[{visibility:'simplified'}]},{featureType:'landscape',stylers:[{visibility:'simplified'}]},{featureType:'poi',stylers:[{visibility:'simplified'}]},{featureType:'road',stylers:[{visibility:'simplified'}]},{featureType:'road.arterial',stylers:[{visibility:'simplified'}]},{featureType:'transit',stylers:[{visibility:'simplified'}]},{featureType:'water',stylers:[{color:'#b3d1ff',visibility:'simplified'}]},{elementType:"labels.icon",stylers:[{visibility:'off'}]}]));
    _gmap.setMapTypeId('style1');

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