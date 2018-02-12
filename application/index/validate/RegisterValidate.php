<?php
namespace app\index\validate;

use think\Validate;

class RegisterValidate extends Validate
{
    protected $rule = [
        'password' => 'require|min:6',
        'phone' => 'require|mobile|unique:users,phone',
        'qq' => 'require',
        'alipay_id' => 'require|unique:users,alipay_id',
        'email' => 'require'
    ];
    protected $message = [
        'email.require' => '店铺名称必须填写',
        'password.require' => '密码必须填写',
        'password.min' => '密码不能小于6位',
        'phone.require' => '手机号码必须填写',
        'phone.mobile' => '手机号格式错误',
        'phone.unique' => '该手机号码已存在',
        'qq.require' => 'qq号码必须填写',
        'alipay_id.require' => "旺旺号码必须填写",
        'alipay_id.unique' => '旺旺号已经存在',
    ];
}