<?php
namespace app\index\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'order_number' => 'require|unique:orders,order_number,,order_id',
        'email' => 'require',
        'alipay_id' => 'require',
        'qq' => 'require',
        'product_name' => 'require',
        'created_at' => 'require',
    ];
    protected $message = [
        'email.require' => '邮箱必须填写',
        'alipay_id.require' => '旺旺号码必须填写',
        'qq.require' => 'qq号码必须填写',
        'product_name.require' => '商品信息必须填写',
        'created_at.require' => "状态日期必须填写",
        'order_number.require' => '订单号必须填写',
        'order_number.unique' => '订单号已存在'
    ];
}
