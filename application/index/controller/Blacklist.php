<?php

namespace app\index\controller;

use app\index\model\Blacklist as BlacklistModel;
use think\Request;

class Blacklist extends Base
{
    public function index(Request $request)
    {
        if ($request->isPost()) {
            $blacklist = BlacklistModel::searchBySomething($request->post()['search']);
            $this->assign("list", $blacklist);
            return view("index/admin-blacklist");
        }
        $blacklist = BlacklistModel::alias("b")
            ->join("tp_users tu", 'tu.id = b.user_id', 'left')
            ->field("b.*,tu.email,tu.alipay_id,tu.qq,tu.id,tu.phone")
            ->paginate(15);
        $this->assign("list", $blacklist);
        return view('index/admin-blacklist');
    }

    public function delBalck(Request $request)
    {
        $black = new BlacklistModel;
        if ($request->isPost()) {
            $data = $request->post();
            $arr = explode(",", $data['all']);
            foreach ($arr as $val) {
                if (empty($val)) {
                    continue;
                }
                $res = $black->delById($val);
            }
            return true;
        }
        $res = $black->delById($request->get("id"));
        if ($res === false) {
            return "这个人已经在黑名单中了";
        }
        return true;
    }

    public function reback(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $arr = explode(",", $data['all']);
            foreach ($arr as $val) {
                if (empty($val)) {
                    continue;
                }
                BlacklistModel::where("user_id", $val)
                    ->delete();
            }
            return true;
        }
        $id = $request->get();
        $res = BlacklistModel::where("user_id", $id['id'])
            ->delete();
        return true;
    }
}
