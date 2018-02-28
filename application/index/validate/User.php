<?php
namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'email' => 'require',
        'password' => 'require|min:6',
    ];
    protected $message = [
        'email.require' => '邮箱必须填写',
        // 'email.email' => '邮箱格式不正确',
        'password.require' => '密码必须填写',
        'password.min' => '密码不能小于6位'
    ];
}