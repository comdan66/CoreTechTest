<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminFormInput as FormInput;
use AdminFormTextarea as FormTextarea;

echo $form->back();

echo $form->form(function($obj) {

  FormInput::create('名稱', 'name')
    ->need()
    ->focus()
    ->val($obj->name);
});