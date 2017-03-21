<?php

// 后台路由
Route::group(['namespace' => 'Admin', 'prefix' => 'backend', 'middleware' => 'auth'], function(){
    Route::get('/', 'IndexController@index');

    // 权限管理
    Route::group(['namespace' => 'Perm', 'prefix' => 'perm'], function(){

        Route::get('user_group/list', 'UserGroupController@index');

    });


});