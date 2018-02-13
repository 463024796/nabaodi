<?php

namespace app\index\model;

use think\Model;

class Blacklist extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    public function delById($alipay_id)
    {
        //获取到alipay_id
        $alipay = self::table('tp_orders')
            ->where("order_id", $alipay_id)
            ->find();
        
        $alipay_id = $alipay['order_alipay_id'];

        if (self::table("tp_black_order")->where("black_order_alipay_id", $alipay_id)->find()) {
            return false;
        }

        self::table("tp_black_order")->insert([
            'black_order_alipay_id' => $alipay_id,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public static function searchBySomething($data)
    {
        return self::alias('b')
            ->join("users u", 'u.id = b.user_id', 'left')
            ->field("b.*, u.qq, u.email, u.alipay_id, u.id,u.phone")
            ->where("u.alipay_id|u.qq|u.email", 'like', '%' . $data . '%')
            ->paginate(15);
    }

    public static function check($alipay_id)
    {
        $user = self::table('tp_black_order')
            ->where("black_order_alipay_id", $alipay_id)
            ->find();
        if ($user) {
            return false;
        }
        return true;
    }

    /**
     * 拉黑店铺
     */
    public function delMemberById($user_id)
    {
        if (self::where("user_id", $user_id)->find()) {
            return false;
        }

        self::insert([
            'user_id' => $user_id,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * 移除黑名单
     */
    public static function remove($alipay_id)
    {
        $res = Orders::where("order_alipay_id", $alipay_id)->find();
        if ($res) {
            $alipay = self::table("tp_black_order")->where("black_order_alipay_id", $res->order_alipay_id)->find();
            if ($alipay) {
                return self::table("tp_black_order")->where("black_order_alipay_id", $res->order_alipay_id)->delete();
            }
        }
        //找不到就说明是用户alipay_id
        $user = User::where("alipay_id", $alipay_id)->find();
        if (!$user) {
            return false;
        }
        $member = self::where("user_id", $user->id)->delete();
        return $member;

    }
}
