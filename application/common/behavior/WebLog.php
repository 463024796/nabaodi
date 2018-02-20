<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace app\common\behavior;

use think\Exception;
use think\Request;
use think\Db;

class WebLog
{
    public function run()
    {
		$request = new Request;
		//不记录的模块
		$not_log_module=config('web_log.not_log_module')?:array();

		//不记录的控制器 'module/controller'
		$not_log_controller=config('web_log.not_log_controller')?:array();

		//不记录的操作方法 'module/controller/action'
		$not_log_action=config('web_log.not_log_action')?:array();

		//不记录data的操作方法 'module/controller/action'
		$not_log_data=['admin/Login/login','admin/Register/runregister'];
		$not_log_data=array_merge($not_log_data,config('web_log.not_log_data')?:array());
		//不记录的操作url
		$not_log_url = [];
		$not_log_url = array_merge($not_log_url,config('web_log')['not_log_url'])? : [];
		//不记录的请求类型
		$not_log_request_method=config('web_log.not_log_request_method')?:array();
		if (
            in_array($request->module(), $not_log_module) ||
			in_array($request->module().'/'.$request->controller(), $not_log_controller) ||
			in_array($request->module().'/'.$request->controller().'/'.$request->action(), $not_log_action) ||
			in_array($request->method(), $not_log_request_method) ||
			in_array('/'.$request->path(), $not_log_url)
        ) {
            return true;
        }
		try {
            if(in_array($request->module().'/'.$request->controller().'/'.$request->action(), $not_log_data)){
				$requestData='保密数据';
            }else{
				$requestData = $request->param();
				foreach ($requestData as &$v) {
					if (is_string($v)) {
						$v = mb_substr($v, 0, 200);
					}
				}
            }
            $data = [
                'uid'       =>session('user')['id']?:0,
                'ip'        => $request->ip(),
                'url'       => '/'.$request->path(),
                'method'    => $request->isAjax()?'Ajax':($request->isPjax()?'Pjax':$request->method()),
                'data'      => json_encode($requestData),
                'otime'     => time(),
            ];
			Db::name('web_log')->insert($data);

        } catch (Exception $e) {
        }
    }
}