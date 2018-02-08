<?php

namespace app\index\controller;

use app\index\model\Orders;
use think\Controller;

class Order extends Base
{
    public function allOrders()
    {
        $order = Orders::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id")
            ->order("or.order_id", 'desc')
            ->paginate(15);
        $this->assign("list", $order);
        return view('index/admin-allOrder');
    }

    public function uncompleted()
    {
        return view('index/admin-uncompleted');
    }

    public function completed()
    {
        return view('index/admin-completed');
    }

    public function recycling()
    {
        return view('index/admin-recyclingStation');
    }
}
