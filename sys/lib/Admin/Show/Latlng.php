<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class AdminShowLatlng extends AdminShowUnitNomin {
  
  public function content($lat) {
    $args = func_get_args();
    $lat = array_shift($args);
    $lng = array_shift($args);

    
    $return = '';
      $return .= '<div class="map" data-lat="' . $lat . '" data-lng="' . $lng . '"></div>';
      $return .= '<div class="zoom">';
        $return .= '<label class="icon-07"></label>';
        $return .= '<label class="icon-61"></label>';
      $return .= '</div>';
    
    parent::content($return);
    return $this->className('maps');
  }
}
