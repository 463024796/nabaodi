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
        // $user = self::table("tp_users")
        //     ->where("email", $data['email'])
        //     ->find();
        // if (!$user) {
        //     //据大佬说。要新增用户
        //     self::table("tp_users")
        //         ->insert([
        //             'email' => $data['email'],
        //             'qq' => $data['qq'],
        //             'alipay_id' => $data['alipay_id'],
        //             'password' => password_hash('888888', PASSWORD_DEFAULT),
        //             'is_admin' => 0,
        //             'created_at' => strtotime($data['created_at']),
        //             'updated_at' => strtotime($data['created_at']),
        //         ]);
        //     //我也不知道怎么了。居然没有id重新查询下把，，，
        //     $user = self::table("tp_users")
        //         ->where("email", $data['email'])
        //         ->find();
        // }
        $user = session("user");
        self::save([
            'user_id' => $user['id'],
            'product_name' => $data['product_name'],
            'order_number' => $data['order_number'],
            'order_qq' => $data['order_qq'],
            'order_alipay_id' => $data['order_alipay_id'],
        ]);
        return true;
    }
    
    /**
     * 未完成订单界面
     */
    public static function getUncompleted()
    {
        if (!session('user')['is_admin']) {
            $where = 'or.user_id='.session('user')['id'];
        } else {
            $where = '';
        }
        return self::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq,u.phone")
            ->order("or.order_id", 'desc')
            ->where("or.status", 0)
            ->where("or.is_deleted", 0)
            ->where($where)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }
    /**
     * 已完成订单界面
     */
    public static function getCompleted()
    {
        if (!session('user')['is_admin']) {
            $where = 'or.user_id='.session('user')['id'];
        } else {
            $where = '';
        }
        return self::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq,u.phone")
            ->order("or.order_id", 'desc')
            ->where("or.status", 1)
            ->where("or.is_deleted", 0)
            ->where($where)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }

    /**
     * 回收站
     */
    public static function getRecycling()
    {
        if (!session('user')['is_admin']) {
            $where = 'or.user_id='.session('user')['id'];
        } else {
            $where = '';
        }
        return self::alias("or")
            ->join("users u", 'u.id = or.user_id', 'left')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq,u.phone")
            ->order("or.order_id", 'desc')
            ->where("or.is_deleted", 1)
            ->where($where)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }

    /**
     * 通过id编辑
     */
    public static function editById($user_id)
    {
        return self::where("order_id", $user_id[6])
            ->update([
                'order_number' => $user_id[1],
                'product_name' => $user_id[4],
                'created_at' => strtotime($user_id[5]),
                'updated_at' => strtotime($user_id[5]),
            ]);
    }

    /**
     * 搜索
     */
    public static function searchForAll($data)
    {
        return self::alias("or")
            ->join("users u", 'or.user_id = u.id', 'left')
            ->where("or.order_alipay_id|or.order_qq", "like", "%" . $data . "%")
            ->order("or.order_id", 'desc')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq,u.phone")
            ->paginate(15)->each(function ($user) {
                $black = Blacklist::where("user_id", $user->id)->find();
                $black2 = Blacklist::table("tp_black_order")->where("black_order_alipay_id", $user->order_alipay_id)->find();
                if ($black) {
                    $user['status'] = 4;
                }
                if ($black2) {
                    $user['status'] = 5;
                }

        });
    }

    /**
     * 批量完成订单
     */
    public static function completedOrder($data, $field = 'order_id', $edit_field = 'status', $field_val = 1)
    {
        $time = time();
        if (is_array($data)) {
            foreach ($data as $val) {
                if (empty($val)) {
                    continue;
                }
                self::where($field, $val)
                    ->update([$edit_field => $field_val, 'updated_at' => $time]);
            }
        } else {
            self::where($field, $data)
                ->update([$edit_field => $field_val, 'updated_at' => $time]);
        }
    }
    /**
     * 未完成查询（alipay_id|qq）
     */
    public static function searchSomething($data, $is)
    {
        
        return self::alias("or")
            ->join("users u", 'or.user_id = u.id', 'left')
            ->where("or.order_alipay_id|or.order_qq", "like", "%" . $data . "%")
            ->order("or.order_id", 'desc')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq,u.phone")
            ->where("or.status", $is)
            ->where("or.is_deleted", 0)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }


    public static function searchRecycling($data)
    {
        return self::alias("or")
            ->join("users u", 'or.user_id = u.id', 'left')
            ->where("or.order_alipay_id|or.order_qq", "like", "%" . $data . "%")
            ->order("or.order_id", 'desc')
            ->field("or.*,u.email, u.id, u.alipay_id,u.qq,u.phone")
            ->where("or.is_deleted", 1)
            ->where('u.id not in (select user_id from tp_blacklist)')
            ->paginate(15);
    }

    public function deleteOrder($data)
    {
        if (is_array($data)) {
            foreach ($data as $val) {
                if (empty($val)) {
                    continue;
                }
                self::where("order_id", $val)
                    ->delete();
            }
        } else {
            self::where("order_id", $data)
                ->delete();
        }
    }

    public function undoCompleted($id)
    {
        return self::where("order_id", $id)
        ->update([
            'status' => 0,
            'updated_at' => time(),
        ]);
    }
}
