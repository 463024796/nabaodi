<?php

namespace app\index\controller;

use app\index\validate\RegisterValidate;
use think\Request;
use app\index\model\User;
use think\Controller;

class Register extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function showView()
    {
        return view("register");
    }

    public function runRegister(Request $request)
    {
        if ($request->isGet()) {
            return $this->showView();
        }

        $data = $request->post();
        //验证数据的准确性
        $res = $this->validator($data);
        if ($res !== true) {
            return redirect('/auth/register')->with('errors', $res);
        }

        //储存用户数据
        $user = new User;
        if (!$user->store($data)) return redirect('/auth/register')->with('errors', "注册失败，请联系管理员");

        return $this->redirect("/auth/login");


    }

    /**
     * @param $data 数据
     * return boolean|array
     */
    protected function validator($data)
    {
        $validate = new RegisterValidate;

        if (!$validate->check($data)) {
            if (is_array($validate->getError())) {
                return $validate->getError();
            }
            $arr[] = $validate->getError();
            return $arr;
        }
        return true;
    }
}
