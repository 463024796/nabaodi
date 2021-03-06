<?php

namespace app\index\controller;

use app\index\model\Announcement;
use app\index\model\Menu;
use think\Controller;

class Base extends Controller
{
    public $user;

    public function __construct()
    {
        parent::__construct();
        //检查是否已经登录
        $this->checkAuth();
        //sidebar
        $this->menu();
        //检测访问的url是否有权限
        $this->checkAuthUrl();
        $this->announcement();
        if (!is_array(session('user'))) {
            $this->user = (array) session('user');
        }
        $this->user = session('user');
    }

    public function checkAuth()
    {
        //如果登录后有按记住状态的话。那就直接跳转
        if (cookie("user") !== null) {
            $user = json_decode(cookie("user"), true);
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
        if (!is_array($user)) {
            $user = (array) $user;
        }
        $data = Menu::getMenu($user);
        $this->assign("user", $user);
        $this->assign("menu", $data);
    }

    protected function checkAuthUrl()
    {
        $user = session('user');
        if (!is_array($user)) {
            $user = (array) $user;
        }
        $request = new \think\Request;
        $path = $request->path();
        //就简易的。。。所有都ok *
        if ($user['is_admin']) {
            //管理员。
            $str = "/^admin\/.*?$/";
        } else {
            $str = "/^index\/.*?$/";
        }
        $str = "/^admin\/.*?$/";
        if (!preg_match($str, $path)) {
            return $this->error("没有权限访问");
        }
    }

    public function announcement()
    {
        $anno = Announcement::find(1);
        $this->assign('anno', $anno->content);
    }
}
