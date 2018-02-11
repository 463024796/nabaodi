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
            'updated_at' => time()
        ]);
    }

    public static function searchBySomething($data)
    {
        return self::alias('b')
        ->join("users u", 'u.id = b.user_id', 'left')
        ->field("b.*, u.qq, u.email, u.alipay_id, u.id")
        ->where("u.alipay_id|u.qq|u.email", 'like', '%'.$data.'%')
        ->paginate(15);
    }
}
