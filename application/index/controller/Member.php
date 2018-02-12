<?php

namespace app\index\controller;

use app\index\model\Blacklist;
use app\index\model\Orders;
use app\index\model\User;
use app\index\validate\MemberOrder;
use think\Request;

class Member extends Base
{
    /**
     * 普通用户登陆就后。。。
     */
    public function showView(Request $request)
    {
        $user = session("user");
        if (!is_array($user)) $user = (array) $user;
        if ($request->isPost()) {
            $data = Orders::where("order_number|product_name", 'like', '%' . $request->post()['search'] . "%")
                ->where("user_id", $user['id'])
                ->paginate(15);
            $this->assign("user", $user);
            $this->assign("list", $data);
            return view('index/admin-bursh');
        }
        $data = Orders::where("user_id", $user['id'])
            ->paginate(15);
        $this->assign("user", $user);
        $this->assign("list", $data);
        return view('index/admin-bursh');
    }

    /**
     * 所有的用户
     */
    public function allMembers(Request $request)
    {
        if ($request->isPost()) {
            $users = User::where("qq|alipay_id", 'like', '%'.$request->post()['search']."%")
            ->paginate(15)->each(function ($user) {
                $blacklist = Blacklist::where("user_id", $user->id)->find();
                $user['black'] = empty($blacklist) ? 0 : 1;
            });
            $this->assign("list", $users);
            return view("index/admin-member");
        }
        $users = User::paginate(15)->each(function ($user) {
            $blacklist = Blacklist::where("user_id", $user->id)->find();
            $user['black'] = empty($blacklist) ? 0 : 1;
        });
        $this->assign("list", $users);
        return view("index/admin-member");
    }

    /**
     * 添加订单
     */
    public function store(Request $request)
    {
        $array['order_number'] = $request->post()['arr'][0];
        $array['product_name'] = $request->post()['arr'][1];
        $validate = new MemberOrder;

        if (!$validate->check($array)) {
            return $validate->getError();
        }

        $user = session('user');
        //储存
        Orders::insert([
            'user_id' => $user['id'],
            'order_number' => $array['order_number'],
            'product_name' => $array['product_name'],
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        return true;
    }
    /**
     * 处理注册
     */
     public function delRegisterMembers(Request $request)
     {
        $order = new User;
        if ($request->isGet()) {
            $order->delRegister($request->get("id"));
            return true;
        }
        //判断是单个还是多个
        $data = $request->post();
        $arr = explode(",", $data['all']);
        
        $res = $order->delRegister($arr);
        return $res;
     }
}
