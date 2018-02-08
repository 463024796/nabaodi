<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// Route::get('think', function () {
//     return 'hello,ThinkPHP5!';
// });

// Route::get('hello/:name', 'index/hello');

Route::group('auth', function() {
    Route::rule('/login', 'index/Login/login');
    Route::get('/logout', 'index/Login/logout');
    Route::rule("/register", 'index/Register/runRegister');
});

Route::group("admin", function(){
    Route::miss("/");
    Route::rule('/show', 'index/index');
    Route::rule('/all-orders', 'index/Order/allOrders');
    Route::rule('/uncompleted', 'index/Order/uncompleted');
    Route::rule('/completed', 'index/Order/completed');
    Route::rule('/recycling', 'index/Order/recycling');
    Route::rule('/blacklist', 'index/Blacklist/index');
});
Route::group("index", function() {
    Route::rule("/show", 'index/Member/showView');
});
return [

];
