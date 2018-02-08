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
