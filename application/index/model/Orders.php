<?php

namespace app\index\model;

use think\Model;

class Orders extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    /**
     * 保存新订单
     */
    public function store($data)
    {
        $user = self::table("tp_users")
            ->where("email", $data['email'])
            ->find();
        if (!$user) {
            //据大佬说。要新增用户
            self::table("tp_users")
                ->insert([
                    'email' => $data['email'],
                    'qq' => $data['qq'],
                    'alipay_id' => $data['alipay_id'],
                    'password' => password_hash('888888', PASSWORD_DEFAULT),
                    'is_admin' => 0,
                    'created_at' => strtotime($data['created_at']),
                    'updated_at' => strtotime($data['created_at']),
                ]);
            //我也不知道怎么了。居然没有id重新查询下把，，，
            $user = self::table("tp_users")
                ->where("email", $data['email'])
                ->find();
        }
        self::save([
            'user_id' => $user->id,
            'product_name' => $data['product_name'],
        ]);
        return true;
    }
    /**
     * 通过id删除订单
     */
    public function deleteById($data)
    {
        if (is_array($data)) {
            foreach ($data as $val) {
                if (empty($val)) {
                    continue;
                }
                self::where("order_id", $val)
                    ->update(['is_deleted' => 1]);
            }
        } else {
            self::where("order_id", $data)
                ->update(["is_deleted" => 1]);
        }

    }
    /**
     * 未完成订单界面
     */
    public static function getUncompleted()
    {
        return self::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq")
            ->order("or.order_id", 'desc')
            ->where("or.status", 0)
            ->where("or.is_deleted", 0)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }
    /**
     * 已完成订单界面
     */
    public static function getCompleted()
    {
        return self::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq")
            ->order("or.order_id", 'desc')
            ->where("or.status", 1)
            ->where("or.is_deleted", 0)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }

    /**
     * 回收站
     */
    public static function getRecycling()
    {
        return self::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq")
            ->order("or.order_id", 'desc')
            ->where("or.is_deleted", 1)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }

    /**
     * 通过id编辑
     */
    public static function editById($user_id)
    {
        return self::where("order_id", $user_id[5])
            ->update([
                'product_name' => $user_id[3],
                'created_at' => strtotime($user_id[4]),
                'updated_at' => strtotime($user_id[4]),
            ]);
    }

    /**
     * 搜索
     */
    public static function searchForAll($data, $type)
    {
        if ($type == 'email') {
            return self::alias("or")
            ->join("users u", 'or.user_id = u.id', 'left')
            ->where("u.email", "like", "%".$data."%")
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq")
            ->paginate(15)->each(function($user){
                $black = Blacklist::where("user_id", $user->id)->find();
                if ($black) $user['status'] = 4;
            });
        } elseif ($type == 'order') {
            echo 3;
            return ;
        } else {
            return self::alias("or")
            ->join("users u", 'or.user_id = u.id', 'left')
            ->where("or.product_name", "like", "%".$data."%")
            ->order("or.order_id", 'desc')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq")
            ->paginate(15)->each(function($user){
                $black = Blacklist::where("user_id", $user->id)->find();
                if ($black) $user['status'] = 4;
            });
        }
    }

    /**
     * 批量完成订单
     */
    public static function completedOrder($data)
    {
        if (is_array($data)) {
            foreach ($data as $val) {
                if (empty($val)) {
                    continue;
                }
                self::where("order_id", $val)
                    ->update(['status' => 1]);
            }
        } else {
            self::where("order_id", $data)
                ->update(["status" => 1]);
        }
    }
    /**
     * 未完成查询
     */
    public static function searchSomething($data, $type, $is)
    {
        if ($type == 'email') {
            return self::alias("or")
            ->join("users u", 'or.user_id = u.id', 'left')
            ->where("u.email", "like", "%".$data."%")
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq")
            ->where("or.status", $is)
            ->where("or.is_deleted", 0)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
        } elseif ($type == 'order') {
            echo 3;
            return ;
        } else {
            return self::alias("or")
            ->join("users u", 'or.user_id = u.id', 'left')
            ->where("or.product_name", "like", "%".$data."%")
            ->order("or.order_id", 'desc')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq")
            ->where("or.status", $is)
            ->where("or.is_deleted", 0)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
        }
    }

    public function rebackOrders($data)
    {
        if (is_array($data)) {
            foreach ($data as $val) {
                if (empty($val)) {
                    continue;
                }
                self::where("order_id", $val)
                    ->update(['is_deleted' => 0]);
            }
        } else {
            self::where("order_id", $data)
                ->update(["is_deleted" => 0]);
        }
    }
}
