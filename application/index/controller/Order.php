<?php

namespace app\index\controller;

use app\index\model\Blacklist;
use app\index\model\Orders;
use app\index\model\Orders as OrderModel;
use app\index\model\User;
use app\index\validate\OrderValidate;
use think\Controller;
use think\Request;

class Order extends Base
{
    /**
     * 显示所有订单
     */
    public function allOrders(Request $request)
    {
        if ($request->isPost()) {
            return $this->seachOrders($request);
        }
        $order = Orders::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq, u.phone")
            ->order("or.order_id", 'desc')
            ->paginate(15)->each(function ($user) {
            $black = Blacklist::where("user_id", $user->id)->find();
            if ($black) {
                $user['status'] = 4;
            }

        });
        $this->assign("list", $order);
        return view('index/admin-allOrder');
    }

    /**
     * 搜索
     */
    public function seachOrders($request)
    {
        $data = Orders::searchForAll($request->post()['seach']);
        $this->assign("list", $data);
        return view('index/admin-allOrder');
    }

    /**
     * 正则是哪种/废除
     */
    protected function match($str)
    {
        $email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        $order = "/^[0-9].*?$/";
        if (preg_match($email, $str)) {
            return "email";
        } elseif (preg_match($order, $str)) {
            return "order";
        } else {
            return "product_name";
        }
    }

    /**
     * 手动添加订单
     */
    public function store(Request $request)
    {
        $data = $request->post();
        $array['order_number'] = $data['data'][0];
        $array['email'] = $data['data'][1];
        $array['alipay_id'] = $data['data'][2];
        $array['qq'] = $data['data'][3];
        $array['product_name'] = $data['data'][4];
        $array['created_at'] = $data['data'][5];
        $array['updated_at'] = $array['created_at'];
        //检测数据是否正确
        $res = $this->verifyForStore($array);
        if ($res !== true) {
            return $res;
        }
        //检测是否位于黑名单
        if (!Blacklist::check($array['alipay_id'])) {
            return "该旺旺号处于黑名单状态，禁止添加订单";
        }
        $order = new OrderModel;
        $result = $order->store($array);
        if ($result !== true) {
            return $result;
        }

        return true;

    }
    /**
     * 检测增加的数据是否正确
     */
    protected function verifyForStore($data)
    {
        $validate = new OrderValidate;

        if (!$validate->check($data)) {
            return $validate->getError();
        }
        return true;
    }

    /**
     * 删除订单
     */
    public function delete(Request $request)
    {
        $order = new OrderModel;
        if ($request->isGet()) {
            $order->completedOrder($request->get("id"), 'order_id', 'is_deleted', 1);
            return true;
        }
        //判断是单个还是多个
        $data = $request->post();
        $arr = explode(",", $data['all']);

        $res = $order->completedOrder($arr, 'order_id', 'is_deleted', 1);
        return $res;
    }

    /**
     * 未完成订单界面
     */
    public function uncompleted(Request $request)
    {
        if ($request->isPost()) {
            return $this->uncompletedSearch($request);
        }
        $order = OrderModel::getUncompleted();
        $this->assign("list", $order);
        return view('index/admin-uncompleted');
    }
    /**
     * 已完成订单界面
     */
    public function completed(Request $request)
    {
        if ($request->isPost()) {
            return $this->completedSearch($request);
        }
        $order = OrderModel::getCompleted();
        $this->assign("list", $order);
        return view('index/admin-completed');
    }
    /**
     * 回收站订单界面
     */
    public function recycling(Request $request)
    {
        if ($request->isPost()) {
            $data = Orders::searchRecycling($request->post()['search']);
            $this->assign("list", $data);
            return view('index/admin-recyclingStation');
        }
        $order = Orders::getRecycling();
        $this->assign("list", $order);
        return view('index/admin-recyclingStation');
    }

    /**
     * 所有订单中，编辑界面页面获取用户订单信息
     */
    public function getOrders(Request $request)
    {
        $user_id = $request->get("id");
        $user = new \app\index\model\User;
        $data = $user->alias('u')
            ->join("orders o", 'o.user_id = u.id', 'right')
            ->where("order_id", $user_id)
            ->field("u.email,u.qq,u.alipay_id,o.*,u.phone")->find();
        $time = strtotime($data['created_at']);
        $data['time'] = date("Y-m-d", $time);
        return $data;
    }
    /**
     * 获取用户信息
     */
    public function getUser(Request $request)
    {
        $user_id = $request->get("id");
        $user = new \app\index\model\User;
        $data = $user->where("id", $user_id)->find();
        $time = strtotime($data['updated_at']);
        $data['time'] = date("Y-m-d", $time);
        return $data;
    }

    /**
     * 编辑保存
     */
    public function edit(Request $request)
    {
        $order = Orders::editById($request->post()['data']);
        return $order;
    }

    /**
     * 批量完成订单
     */
    public function delOrders(Request $request)
    {
        $order = new OrderModel;
        if ($request->isGet()) {
            $order->completedOrder($request->get("id"));
            return true;
        }
        //判断是单个还是多个
        $data = $request->post();
        $arr = explode(",", $data['all']);

        $res = $order->completedOrder($arr);
        return $res;
    }
    /**
     * 未完成页面的搜索
     */
    public function uncompletedSearch($request)
    {
        // $res = $this->match($request->post()['search']);
        $data = Orders::searchSomething($request->post()['search'], 0);
        $this->assign("list", $data);
        return view('index/admin-uncompleted');
    }

    /**
     * 一键还原
     */
    public function rebackOrders(Request $request)
    {
        $order = new OrderModel;
        if ($request->isGet()) {
            $order->completedOrder($request->get("id"), 'order_id', 'is_deleted', 0);
            return true;
        }
        //判断是单个还是多个
        $data = $request->post();
        $arr = explode(",", $data['all']);

        $res = $order->completedOrder($arr, 'order_id', 'is_deleted', 0);
        return $res;
    }

    /**
     * 已完成页面的搜索
     */
    public function completedSearch($request)
    {
        // $res = $this->match($request->post()['search']);
        $data = Orders::searchSomething($request->post()['search'], 1);
        $this->assign("list", $data);
        return view('index/admin-completed');
    }

    /**
     * 彻底删除
     */
    public function realDelete(Request $request)
    {
        $order = new OrderModel;
        if ($request->isGet()) {
            $order->deleteOrder($request->get("id"));
            return true;
        }
        //判断是单个还是多个
        $data = $request->post();
        $arr = explode(",", $data['all']);

        $res = $order->deleteOrder($arr);
        return $res;
    }

    /**
     * 更改用户信息
     */
    public function modifyUser(Request $request)
    {
        $arr['alipay_id'] = $request->post()['data'][2];
        $arr['qq'] = $request->post()['data'][3];
        $arr['id'] = $request->post()['data'][5];
        if (!User::edit($arr)) {
            return "修改失败";
        }
        return true;
    }
    /**
     * 撤销完成
     */
    public function undoCompleted(Request $request)
    {
        $order = new OrderModel;
        if ($request->isPost()) {
            $data = $request->post();
            $arr = explode(",", $data['all']);
            foreach ($arr as $val) {
                $order->undoCompleted($val);
            }
            return true;
        }
        $id = $request->get("id");
        if (!$order->undoCompleted($id)) {
            return false;
        }
        return true;
    }
}
