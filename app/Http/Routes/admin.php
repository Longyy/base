<?php

// 后台路由
Route::group(['namespace' => 'Admin', 'prefix' => 'backend', 'middleware' => 'auth'], function($oRouter){
    $oRouter->get('/', 'IndexController@index');

    // 权限管理
    $oRouter->group(['namespace' => 'Perm', 'prefix' => 'perm'], function($oRouter){

        $oRouter->get('user_group/list', 'UserGroupController@index');
        $oRouter->get('user_group/get_list', 'UserGroupController@getList');
        $oRouter->get('user_group/edit', 'UserGroupController@edit');
        $oRouter->post('user_group/update', 'UserGroupController@update');

    });


});