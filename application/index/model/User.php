<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $table = "tp_Users";
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    /**
     * 验证密码
     */
    public function verify($email, $pwd)
    {
        $user = self::where("phone", $email)->find();
        if (!$user) {
            return "帐号不存在";
        }
        if (!password_verify($pwd, $user->password)) {
            return false;
        }

        if (Blacklist::where("user_id", $user->id)->find()) {
            return "违反相关规定。禁止登录";
        }
        if ($user->status === 0) {
            return "该帐号需要等待管理员通过注册，请联系管理员";
        }
        return $user;
    }

    public function store($data)
    {
        //加密密码
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $res = self::save($data);
        return $res;
    }

    public static function edit($data)
    {
        return self::where("id", $data['id'])
            ->update([
                'qq' => $data['qq'],
                'alipay_id' => $data['alipay_id'],
                'updated_at' => time(),
            ]);
    }

    public function delRegister($data)
    {
        $time = time();
        if (is_array($data)) {
            $n = 0;
            foreach ($data as $val) {
                if (empty($val)) {
                    continue;
                }
                self::where("id", $val)
                    ->update(['status' => 1, 'updated_at' => $time]);
                $n++;
            }
            return $n;
        }
        return self::where("id", $data)
            ->update(['status' => 1, 'updated_at' => $time]);
    }
}
