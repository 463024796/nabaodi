<?php
namespace app\index\controller;

use think\helper\Time;
use app\index\model\User;
use app\index\model\Orders;

class Index extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        list($start_y, $end_y) = Time::yesterday();
        
        $order = new Orders;
        $user = new User;
        //昨日提交订单
        $yesterday = $order->whereTime('created_at', 'between', [$start_y, $end_y])->count();
        //未处理订单
        $not = $order->where("status", 0)->count();
        //已完成
        $complete = $order->where("status", 1)->count();
        //客户数量
        $count = $user->where("is_admin", 0)->count();

        $this->assign("yesterday", $yesterday);
        $this->assign("not", $not);
        $this->assign("complete", $complete);
        $this->assign("count", $count);
        return view('admin-index');
    }
}
