<?php

namespace app\index\controller;

class Member extends Base
{
    public function __construct()
    {
    
    }

    public function showView()
    {
        return view('index/admin-bursh');
    }
}
