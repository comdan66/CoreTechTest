<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class ShopMain extends AdminCrudController {
  
  public function __construct() {
    parent::__construct();

    wtfTo('AdminShopMainIndex');

    if (in_array(Router::methodName(), ['edit', 'update', 'delete', 'show']))
      if (!$this->obj = \M\ShopMain::one('id = ?', Router::params('id')))
        error('找不到資料！');

    $this->view->with('title', '商店上稿')
               ->with('currentUrl', Url::toRouter('AdminShopMainIndex'));
  }

  public function index() {
    $list = AdminList::create('\M\ShopMain', ['include' => ['photos']])
                     ->setAddUrl(Url::toRouter('AdminShopMainAdd'));

    return $this->view->with('list', $list);
  }
  
  public function add() {

    $this->asset->addCss('/asset/css/admin/ShopMain/plugin.css')
               ->addJS('/asset/js/admin/ShopMain/plugin.js');

    $form = AdminForm::create()
                     ->setActionUrl(Url::toRouter('AdminShopMainCreate'))
                     ->setBackUrl(Url::toRouter('AdminShopMainIndex'));

    return $this->view->with('form', $form);
  }
  
  public function create() {
    wtfTo('AdminShopMainAdd');

    $params = Input::post();
    $files  = Input::file();

    validator(function() use (&$params, &$files) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
      Validator::need($params, 'title', '標題')->isVarchar(190);
      Validator::need($files, 'images', '圖片', [])->filterUploadFiles(config('upload', 'picture'));
      Validator::need($params, 'text', '內文')->isText();

      Validator::need($params, 'areaMainId', '縣市 ID')->isId('\M\AreaMain');
      Validator::need($params, 'areaSubId', '市區 ID')->isId('\M\AreaSub');
      
      Validator::need($params, 'foodMainId', '分類 ID')->isId('\M\FoodMain');
      Validator::need($params, 'foodSubIds', '標籤 IDs')->filter(\M\FoodSub::arr('id'));

      Validator::need($params, 'address', '地址')->isVarchar(190);
      Validator::need($params, 'tel', '電話')->isVarchar(190);

      Validator::need($params, 'station', '捷運站')->isText();
      Validator::need($params, 'holiday', '休假日')->isText();
      Validator::need($params, 'openTime', '營業時間')->isText();
      Validator::need($params, 'info', '資訊')->isText();

      Validator::need($params, 'longitude', '緯度')->isLatLng();
      Validator::need($params, 'latitude', '經度')->isLatLng();
    });


    transaction(function() use (&$params, &$files) {
      if (!$obj = \M\ShopMain::create($params))
        return false;

      foreach ($files['images'] as $i => $file) {
        $photo = [
          'shopMainId' => $obj->id,
          'photoNum' => '0',
          'filename' => '',
          'sort' => $i
        ];

        if (!$photo = \M\ShopPhoto::create($photo))
          return false;

        if (!$photo->filename->put($file))
          return false;
      }

      foreach (\M\ShopFood::all('shopMainId = ?', $obj->id) as $shopFood)
        $shopFood->delete();

      foreach ($params['foodSubIds'] as $foodSubId)
        if (!\M\ShopFood::create(['shopMainId' => $obj->id, 'foodSubId' => $foodSubId]))
          return false;

      return true;
    });


    Url::refreshWithSuccessFlash(Url::toRouter('AdminShopMainIndex'), '新增成功！');
  }
  
  public function edit() {
    $this->asset->addCss('/asset/css/admin/ShopMain/plugin.css')
               ->addJS('/asset/js/admin/ShopMain/plugin.js');

    $form = AdminForm::create($this->obj)
                     ->setActionUrl(Url::toRouter('AdminShopMainUpdate', $this->obj))
                     ->setBackUrl(Url::toRouter('AdminShopMainIndex'));

    return $this->view->with('form', $form);
  }
  
  public function update() {
    wtfTo('AdminShopMainEdit', $this->obj);

    $params = Input::post();
    $files  = Input::file();

    validator(function() use (&$params, &$files) {
      Validator::need($params, 'name', '名稱')->isVarchar(190);
      Validator::need($params, 'title', '標題')->isVarchar(190);
      Validator::maybe($files, 'images', '圖片', [])->filterUploadFiles(config('upload', 'picture'));
      Validator::maybe($params, '_images', '_圖片', [])->isArray();
      
      $params['_images'] = array_filter($params['_images']);

      Validator::need($params, 'text', '內文')->isText();

      Validator::need($params, 'areaMainId', '縣市 ID')->isId('\M\AreaMain');
      Validator::need($params, 'areaSubId', '市區 ID')->isId('\M\AreaSub');
      
      Validator::need($params, 'foodMainId', '分類 ID')->isId('\M\FoodMain');
      Validator::need($params, 'foodSubIds', '標籤 IDs')->filter(\M\FoodSub::arr('id'));

      Validator::need($params, 'address', '地址')->isVarchar(190);
      Validator::need($params, 'tel', '電話')->isVarchar(190);

      Validator::need($params, 'station', '捷運站')->isText();
      Validator::need($params, 'holiday', '休假日')->isText();
      Validator::need($params, 'openTime', '營業時間')->isText();
      Validator::need($params, 'info', '資訊')->isText();

      Validator::need($params, 'longitude', '緯度')->isLatLng();
      Validator::need($params, 'latitude', '經度')->isLatLng();

      $files['images'] || $params['_images'] || error('至少要一張圖片！');
    });

    transaction(function() use (&$params, &$files) {
      if (!($this->obj->columnsUpdate($params) && $this->obj->save()))
        return false;

      $oris = arrayColumn($this->obj->photos, 'id');
      $dels = array_diff($oris, $params['_images']);
      
      foreach ($dels as $del)
        if ($photo = \M\ShopPhoto::one('id = ? AND shopMainId = ?', $del, $this->obj->id))
          if (!$photo->delete())
            return false;

      foreach ($files['images'] as $i => $file) {
        $photo = [
          'shopMainId' => $this->obj->id,
          'photoNum' => '0',
          'filename' => '',
          'sort' => $i
        ];

        if (!$photo = \M\ShopPhoto::create($photo))
          return false;

        if (!$photo->filename->put($file))
          return false;


      foreach (\M\ShopFood::all('shopMainId = ?', $this->obj->id) as $shopFood)
        $shopFood->delete();

      foreach ($params['foodSubIds'] as $foodSubId)
        if (!\M\ShopFood::create(['shopMainId' => $this->obj->id, 'foodSubId' => $foodSubId]))
          return false;

      }

      return true;
    });
    
    Url::refreshWithSuccessFlash(Url::toRouter('AdminShopMainIndex'), '修改成功！');
  }
  
  public function show() {

    $this->asset->addCss('/asset/css/admin/ShopMain/plugin.css')
               ->addJS('/asset/js/admin/ShopMain/plugin.js');

    $show = AdminShow::create($this->obj)
                     ->setBackUrl(Url::toRouter('AdminShopMainIndex'), '回列表');

    return $this->view->with('show', $show);
  }
  
  public function delete() {
    wtfTo('AdminShopMainIndex');
    
    transaction(function() {
      return $this->obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('AdminShopMainIndex'), '刪除成功！');
  }
}
