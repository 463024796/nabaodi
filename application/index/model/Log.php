<?php
/*
-------
自动写入log表
 */
namespace app\index\model;

use think\Model;

class Log extends Model
{
    protected $table = "tp_web_log";

    public static function getLog()
    {
        return self::join("users", 'users.id = tp_web_log.uid', 'left')
            ->field("tp_web_log.*, users.email, users.alipay_id, users.qq, users.phone")
            ->order("created_at", 'desc')
            ->paginate(15)->each(function ($user) {
            $user['title'] = config('action_name')[$user['url']];
            $data = json_decode($user['data'], true);
            //以all推键名提交
            if (isset($data['all'])) {
                $all = explode(",", $data['all']);
                $where = "";
                foreach ($all as $v) {
                    if (empty($all)) {
                        continue;
                    }
                    if ($v == 'on') {
                        continue;
                    }

                    $where .= $v . ",";
                }

                $where = substr($where, 0, strlen($where) - 1);
                //获取用户名字
                $user['user_name'] = Orders::where("user_id", 'in', $where)
                    ->field("Group_concat(order_alipay_id) as user_name")
                    ->find()['user_name'];
                //当上面没有找到的话。就转向店铺本人
                if (empty($user['user_name'])) {
                    $user['user_name'] = User::where("alipay_id", 'in', $where)
                        ->field("Group_concat(alipay_id) as user_name")
                        ->find()['user_name'];
                }
                //这些都是一些以order_id的唯一识别
                if ($user['title'] == '完成订单' or $user['title'] == '删除订单' or $user['title'] == '撤销完成订单') {
                    $user['user_name'] = Orders::where("order_id", 'in', $where)
                        ->field("Group_concat(order_alipay_id) as user_name")
                        ->find()['user_name'];
                }
                //如果是以data为键名、、是关于提交用户信息或者编辑用户信息
            } elseif (isset($data['data'])) {
                if ($user['title'] == '添加订单' || $user['title'] == "编辑订单") {
                    $user['user_name'] = $data['data']['1'];
                } else {
                    $user['user_name'] = User::where("id", $data['data']['5'])
                        ->field("alipay_id as user_name")
                        ->find()['user_name'];
                }
                //以id为键名。标识。 一般就是以单个人的形式提交
            } else {
                //如果是黑名单相关的，那么->2个表。
                if (strpos($user['url'], 'blacklist')) {
                    //第一个表->用户黑名单表->
                    // dump($data);
                    //带有member的传上来是用户id。标识用户的唯一id
                    if (strpos($user['url'], 'member')) {
                        $user['user_name'] = User::where("id", $data['id'])
                            ->field("alipay_id as user_name")
                            ->find()['user_name'];
                    } else {
                        //直接是旺旺号 因为前端传上来的就是旺旺号。、
                        $user['user_name'] = $data['id'];
                    }
                } else {
                    $user['user_name'] = Orders::where("order_id", $data['id'])
                        ->field("order_alipay_id as user_name")
                        ->find()['user_name'];
                }

            }
        });
    }

    public function search()
    {
        
    }
}
