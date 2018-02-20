<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Log;

class WebLog extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        if ($request->isPost()) {
            $search = $request->post()['search'];
            
        }
        $log = Log::getLog(15);
        $this->assign("list", $log);
        return view("index/admin-log");
    }
}
