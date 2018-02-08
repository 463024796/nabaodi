<?php

namespace app\index\controller;

use think\Request;

class Blacklist extends Base
{
    public function index()
    {
        return view('index/admin-blacklist');
    }
}
