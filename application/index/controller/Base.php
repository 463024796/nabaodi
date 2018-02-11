<?php

namespace app\index\controller;

use app\index\model\Menu;
use think\Controller;

class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //检查是否已经登录
        $this->checkAuth();
        //sidebar
        $this->menu();
        //检测访问的url是否有权限
        $this->checkAuthUrl();
    }

    public function checkAuth()
    {
        //如果登录后有按记住状态的话。那就直接跳转
        if (cookie("user") !== null) {
            $user = json_decode(cookie("user"));
            session("user", $user);
        }
        if (!session("?user")) {
            return $this->redirect('/auth/login');
        }
    }

    /**
     * 侧边栏按钮
     */
    protected function menu()
    {
        //判断当前登录的用户是管理员还是普通用户
        $user = session('user');
        $data = Menu::where('type', $user['is_admin'])
            ->select();
        $this->assign("menu", $data);
    }

    protected function checkAuthUrl()
    {
        $user = session('user');
        $request = new \think\Request;
        $path = $request->path();
        //就简易的。。。所有都ok *
        if ($user['is_admin']) {
            //管理员。
            $str = "/^admin\/.*?$/";
        } else {
            $str = "/^index\/.*?$/";
        }
        if (!preg_match($str, $path)) {
            return $this->error("没有权限访问");
        }
    }
}
