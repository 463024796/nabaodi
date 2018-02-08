<?php
namespace app\index\validate;

use think\Validate;

class RegisterValidate extends Validate
{
    protected $rule = [
        'email' => 'require|email|unique:users',
        'password' => 'require|min:6',
        'phone' => 'require|mobile',
        'qq' => 'require',
        'alipay_id' => 'require'
    ];
    protected $message = [
        'email.require' => '邮箱必须填写',
        'email.email' => '邮箱格式不正确',
        'password.require' => '密码必须填写',
        'password.min' => '密码不能小于6位',
        'phone.require' => '手机号码必须填写',
        'phone.mobile' => '手机号格式错误',
        'qq.require' => 'qq号码必须填写',
        'alipay_id.require' => "旺旺号码必须填写"
    ];
}