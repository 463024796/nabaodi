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
    // Route::miss("/");
    Route::rule('/show', 'index/index');
    Route::rule("/all-members", 'index/Member/allMembers');
    Route::rule('/all-orders', 'index/Order/allOrders');
    Route::rule('/uncompleted', 'index/Order/uncompleted');
    Route::rule('/completed', 'index/Order/completed');
    Route::rule('/recycling', 'index/Order/recycling');
    Route::rule('/blacklist', 'index/Blacklist/index');
    Route::post('/orders/add', 'index/Order/store');
    Route::rule('/orders/delete', 'index/Order/delete');
    Route::rule("/orders/del-black", 'index/Blacklist/delBalck');
    Route::get("/user", 'index/Order/getUser');
    Route::post("/orders/edit", 'index/Order/edit');
    Route::get('/blacklist/del-reback', 'index/Blacklist/reback');
    Route::rule("/orders/del-order", 'index/Order/delOrders');
    Route::rule("/orders/del-order-reback", 'index/Order/rebackOrders');
});
Route::group("index", function() {
    Route::rule("/show", 'index/Member/showView');
});
return [

];
