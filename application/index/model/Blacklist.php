<?php

namespace app\index\model;

use think\Model;

class Blacklist extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    public function delById($user_id)
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
        $user = self::table('tp_users')
        ->where("alipay_id", $alipay_id)
        ->find();
        if ($user) {
            $res = self::where("user_id", $user->id)
            ->find();
            if($user) {
                return false;
            }
        }
        return true;
    }
}
