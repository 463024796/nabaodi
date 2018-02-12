<?php

namespace app\index\model;

use think\Model;

class Menu extends Model
{
    public static function getMenu($user)
    {
        $allMenus = self::all();
        $auth = self::table('tp_auth')
            ->where("group_id", $user['is_admin'])
            ->find();
        //获取权限
        $rule = explode(",", $auth->rule);
        $menus = [];
        foreach ($allMenus as $key => $val) {
            foreach ($rule as $k => $v) {
                if ($val['id'] == $v) {
                    array_push($menus, $val);
                }
            }
        }
        return $menus;
    }
}
