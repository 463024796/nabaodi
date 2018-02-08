<?php

namespace app\index\model;

use think\Model;

class Orders extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
