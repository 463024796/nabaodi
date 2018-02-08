<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //检查是否已经登录
        $this->checkAuth();
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
}
