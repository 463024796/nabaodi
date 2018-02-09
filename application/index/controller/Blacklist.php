<?php

namespace app\index\controller;

use app\index\model\Blacklist as BlacklistModel;
use think\Request;

class Blacklist extends Base
{
    public function index()
    {
        $blacklist = BlacklistModel::alias("b")
            ->join("tp_users tu", 'tu.id = b.user_id', 'left')
            ->field("b.*,tu.email,tu.alipay_id,tu.qq,tu.id")
            ->paginate(15);
        $this->assign("list", $blacklist);
        return view('index/admin-blacklist');
    }

    public function delBalck(Request $request)
    {
        $black = new BlacklistModel;
        $res = $black->delById($request->get("id"));
        if ($res === false) {
            return "这个人已经在黑名单中了";
        }
        return true;
    }

    public function reback(Request $requset)
    {
        $id = $requset->get();
        $res = BlacklistModel::where("user_id", $id['id'])
            ->delete();
        return true;
    }
}
