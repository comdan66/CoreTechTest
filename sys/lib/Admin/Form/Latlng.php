<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class AdminFormLatlng {
  protected $title, $tip, $lat, $lng, $need, $obj, $latVal, $lngVal, $latPlaceholder, $lngPlaceholder;
  
  public static function create($title, $lat, $lng) {
    return new static($title, $lat, $lng);
  }
  
  public function __construct($title, $lat, $lng) {
    $traces = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
    
    foreach ($traces as $trace)
      if (isset($trace['object']) && $trace['object'] instanceof AdminForm && method_exists($trace['object'], 'appendUnit') && $this->obj = $trace['object'])
        break;

    $this->obj->appendUnit($this);
    $this->title($title);
    $this->lat($lat);
    $this->lng($lng);
  }
  public function latVal($latVal) {
    $this->latVal = $latVal;
    return $this;
  }
  public function lngVal($lngVal) {
    $this->lngVal = $lngVal;
    return $this;
  }
  public function latPlaceholder($latPlaceholder) {
    $this->latPlaceholder = $latPlaceholder;
    return $this;
  }
  public function lngPlaceholder($lngPlaceholder) {
    $this->lngPlaceholder = $lngPlaceholder;
    return $this;
  }

  public function title($title) {
    $this->title = $title;
    return $this;
  }
  
  public function tip($tip) {
    $this->tip = $tip;
    return $this;
  }

  public function lat($lat) {
    $this->lat = $lat;
    return $this;
  }

  public function lng($lng) {
    $this->lng = $lng;
    return $this;
  }

  public function need($need = true) {
    $this->need = $need;
    return $this;
  }
  
  protected function getContent() {
    $latVal = (is_array(AdminForm::$flash) ? array_key_exists($this->lat, AdminForm::$flash) : AdminForm::$flash[$this->lat] !== null) ? AdminForm::$flash[$this->lat] : $this->latVal;
    $lngVal = (is_array(AdminForm::$flash) ? array_key_exists($this->lng, AdminForm::$flash) : AdminForm::$flash[$this->lng] !== null) ? AdminForm::$flash[$this->lng] : $this->lngVal;

    $latAttrs = $lngAttrs = [];

    $latAttrs = [
      'type'  => 'text', 'readonly' => true,
      'name' => $this->lat,
      'data-id' => 'lat',
      'value' => $latVal,
    ];
    $this->latPlaceholder && $latAttrs['latPlaceholder'] = $this->latPlaceholder;
    $this->need && $latAttrs['required'] = true;

    $lngAttrs = [
      'type'  => 'text', 'readonly' => true,
      'name' => $this->lng,
      'data-id' => 'lng',
      'value' => $lngVal,
    ];
    $this->lngPlaceholder && $attrs['lngPlaceholder'] = $this->lngPlaceholder;
    $this->need && $lngAttrs['required'] = true;

    $return = '';
    $return .= '<div class="maps">';
      $return .= '<div class="map"></div>';
      $return .= '<label><input' . attr($latAttrs) .'></label>';
      $return .= '<label><input' . attr($lngAttrs) .'></label>';
      $return .= '<div class="zoom">';
        $return .= '<label class="icon-07"></label>';
        $return .= '<label class="icon-61"></label>';
      $return .= '</div>';
    $return .= '</div>';
    return $return;
  }

  public function __toString() {
    $attrs = [];
    $this->need && $attrs['class'] = 'need';
    $this->tip && $attrs['data-tip'] = $this->tip;

    if ($this instanceof AdminFormInput && $this->type() == 'hidden')
      return $this->getContent();

    $return = '';
    $return .= '<div class="row">';
      $return .= '<b' . attr($attrs) . '>' . $this->title . '</b>';
      $return .= $this->getContent();
    $return .= '</div>';

    return $return;
  }
}