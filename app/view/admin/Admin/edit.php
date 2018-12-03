<?php defined('MAPLE') || exit('此檔案不允許讀取！');

use AdminFormInput as FormInput;
use AdminFormCheckbox as FormCheckbox;

echo $form->back();

echo $form->form(function($obj) {

  FormInput::create('名稱', 'name')
    ->need()
    ->focus()
    ->val($obj->name);

  FormInput::create('帳號', 'account')
    ->need()
    ->val($obj->account);

  FormInput::create('密碼', 'password')
    ->type('password')
    ->need()
    ->val('');

  FormCheckbox::create('角色', 'roles')
    ->items(\M\AdminRole::ROLE)
    ->need()
    ->val(arrayColumn($obj->roles, 'role'));
});