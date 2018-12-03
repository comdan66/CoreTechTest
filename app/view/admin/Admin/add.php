<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminFormInput as FormInput;
use AdminFormCheckbox as FormCheckbox;

echo $form->back();

echo $form->form(function() {

  FormInput::create('名稱', 'name')
    ->need()
    ->focus();

  FormInput::create('帳號', 'account')
    ->need();

  FormInput::create('密碼', 'password')
    ->type('password')
    ->need();

  FormCheckbox::create('角色', 'roles')
    ->items(\M\AdminRole::ROLE)
    ->need();
});