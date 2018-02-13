<?php

namespace app\index\controller;

use app\index\model\Blacklist as BlacklistModel;
use think\Request;

class Blacklist extends Base
{
    public function index(Request $request)
    {
        //超管
        if (session("user")['is_admin']) {
            $blacklist = BlacklistModel::alias("b")
                ->join("tp_users tu", 'tu.id = b.user_id', 'left')
                ->field("b.*,tu.email,tu.alipay_id,tu.qq,tu.id,tu.phone")
                ->select();
            //订单黑名单
            $blacklist2 = BlacklistModel::table("tp_black_order")
                ->alias("tbo")
                ->field("or.*,tbo.black_order_alipay_id as alipay_id")
                ->join("tp_orders or", 'or.order_alipay_id = tbo.black_order_alipay_id', 'left')
                ->select()->toArray();
            foreach ($blacklist2 as $key => $val) {
                $blacklist2[$key]['email'] = "客户";
            }
            $black = array_merge_recursive($blacklist->toArray(), $blacklist2);
        } else {
            //普通用户
            $black = BlacklistModel::table("tp_black_order")
            ->alias("tbo")
            ->field("or.*,tbo.black_order_alipay_id as alipay_id")
            ->join("tp_orders or", 'or.order_alipay_id = tbo.black_order_alipay_id', 'left')
            ->select()->toArray();
            foreach ($black as $key => $val) {
                $black[$key]['email'] = "客户";
            }
        }
        
        if ($request->isPost()) {
            $search = $request->post()['search'];
            $arr = [];
            foreach ($black as $key => $val) {
                if ((isset($val['alipay_id']) and $val['alipay_id'] == $search) or (isset($val['order_alipay_id']) and $val['order_alipay_id'] == $search)) {
                    array_push($arr, $val);
                }elseif ((isset($val['qq']) and $val['qq'] == $search) or (isset($val['order_qq']) and $val['order_qq'] == $search)) {
                    array_push($arr, $val);
                }
            }
            if (!empty($arr)) $black = $arr;
        }
        $count = count($black);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $listRow = 15;
        $start = ($page == 1) ? 0 : $listRow * ($page - 1);
        $black = array_slice($black, $start, $listRow);
        $pages = ceil($count / $listRow);

        $render = getPageHtml($page, $pages, '/admin/blacklist?');

        
        $this->assign("render", $render);
        $this->assign("list", $black);
        $this->assign("count", $count);
        return view('index/admin-blacklist');
    }

    public function delBalck(Request $request)
    {
        //订单黑名单。
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

    public function delMemberBlack(Request $request)
    {
        //订单黑名单。
        $black = new BlacklistModel;
        if ($request->isPost()) {
            $data = $request->post();
            $arr = explode(",", $data['all']);
            foreach ($arr as $val) {
                if (empty($val)) {
                    continue;
                }
                $res = $black->delMemberById($val);
            }
            return true;
        }
        $res = $black->delMemberById($request->get("id"));

        if ($res === false) {
            return "这个人已经在黑名单中了";
        }
        return true;
    }

    /**
     * 移除黑名单
     */
    public function reback(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $arr = explode(",", $data['all']);
            foreach ($arr as $val) {
                if (empty($val)) {
                    continue;
                }
                //先判断是哪个黑名单。所给的是alipay_id
                BlacklistModel::remove($val);
            }
            return true;
        }
        $id = $request->get();
        BlacklistModel::remove($id['id']);
        return true;
    }
}
