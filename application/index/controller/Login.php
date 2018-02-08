<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\User;

class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function showView()
    {
        return view("login");
    }

    /**
     * 登录
     */
    public function login(Request $request)
    {
        if ($request->isGet()) {
            return $this->showView();
        }

        //提交登录信息
        $data = $request->post();
        //验证数据的准确性
        $res = $this->validator($data);
        if ($res !== true) return redirect('/auth/login')->with('errors', $res);
        
        $user = new User();
        if (!$loginRes = $user->verify($data['email'], $data['password'])) {
            return $this->sendLoginFail();
        }
        if (isset($data['remember']) and !empty($data['remember'])) {
            $this->remember($loginRes);
        }
        return $this->sendLoginSuccess($loginRes);
    }

    /**
     * @param $data 数据
     * return boolean|array
     */
    protected function validator($data)
    {
        $validate = new \app\index\validate\User;

        if (!$validate->check($data)) {
            if (is_array($validate->getError())) {
                return $validate->getError();
            }
            $arr[] = $validate->getError();
            return $arr;
        }
        return true;
    }
    
    /**
     * 登录不成功的情况下
     */
    protected function sendLoginFail()
    {
        return redirect("/auth/login")->with("errors", [0 => '帐号或密码错误']);
    }
    
    /**
     * 登录成功的情况下
     */
    protected function sendLoginSuccess($loginRes)
    {
        session('user', $loginRes);
        //判断是否为admin
        if ($loginRes->is_admin) {
            return redirect("/admin/show");
        }
        //会员页面
        return redirect("/index/show");
        
    }

    public function logout()
    {
        session('user', null);
        cookie("user", null);
        return $this->redirect('/auth/login');
    }

    public function remember($user)
    {
        cookie("user", $user, 3600 * 24 *7);
    }
}
