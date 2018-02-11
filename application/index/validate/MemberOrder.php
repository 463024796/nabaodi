<?php
namespace app\index\validate;

use think\Validate;

class MemberOrder extends Validate
{
    protected $rule = [
        'order_number' => 'require|unique:orders,order_number,,order_id',
        'product_name' => 'require',
    ];
    protected $message = [
        'product_name.require' => '商品信息必须填写',
        'order_number.require' => '订单号必须填写',
        'order_number.unique' => '订单号已存在'
    ];
}
