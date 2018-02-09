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
        $user = self::where("email", $email)->find();
        if (!password_verify($pwd, $user->password)) {
            return false;
        }

        if (Blacklist::where("user_id", $user->id)->find()) {
            return "违反相关规定。禁止登录";
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
}
