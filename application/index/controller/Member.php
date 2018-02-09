<?php

namespace app\index\controller;

use app\index\model\User;
use app\index\model\Blacklist;

class Member extends Base
{
    public function showView()
    {
        return view('index/admin-bursh');
    }

    public function allMembers()
    {
        $users = User::where("is_admin", 0)->paginate(15)->each(function($user) {
            $blacklist = Blacklist::where("user_id", $user->id)->find();
            $user['black'] = empty($blacklist) ? 0 : 1;
        });
        $this->assign("list", $users);
        return view("index/admin-member");
    }
}
