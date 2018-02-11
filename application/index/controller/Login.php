<?php

namespace app\index\controller;

use app\index\model\Menu;
use app\index\model\User;
use think\Controller;
use think\Request;

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
        if ($res !== true) {
            return redirect('/auth/login')->with('errors', $res);
        }

        $user = new User();
        $loginRes = $user->verify($data['email'], $data['password']);
        if (!$loginRes instanceof User) {
            return $this->sendLoginFail($loginRes);
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
    protected function sendLoginFail($res)
    {
        if ($res === false) {
            $str = "帐号或密码错误";
        } else {
            $str = $res;
        }

        return redirect("/auth/login")->with("errors", [0 => $str]);
    }

    /**
     * 登录成功的情况下
     */
    protected function sendLoginSuccess($loginRes)
    {
        session('user', $loginRes);
        //获取url。为了接下来判断是否有权限访问
        $menu = Menu::where("type", $loginRes->is_admin)
            ->select();
        session('menu', $menu);
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
        cookie("user", $user, 3600 * 24 * 7);
    }
}
