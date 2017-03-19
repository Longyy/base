<?php

// 后台路由
Route::group(['namespace' => 'Admin', 'prefix' => 'backend', 'middleware' => 'auth'], function($oRouter){
    $oRouter->get('/', 'IndexController@index');

    

});