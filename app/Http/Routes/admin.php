<?php

// 后台路由
Route::group(['namespace' => 'Admin', 'prefix' => 'backend', 'middleware' => ['auth', 'privilege']], function($oRouter){
    $oRouter->get('/', 'IndexController@index');
    $oRouter->post('/change_group', 'IndexController@changeGroup');

    // 用户管理
    $oRouter->get('user/list', 'AdminUserController@index');
    $oRouter->get('user/get_list', 'AdminUserController@getList');

    // 权限管理
    $oRouter->group(['namespace' => 'Perm', 'prefix' => 'perm'], function($oRouter){

        // 用户组管理
        $oRouter->get('user_group/list', 'CommonUserGroupController@index');
        $oRouter->get('user_group/get_list', 'CommonUserGroupController@getList');
        $oRouter->get('user_group/edit', 'CommonUserGroupController@edit');
        $oRouter->post('user_group/update', 'CommonUserGroupController@update');
        $oRouter->get('user_group/create', 'CommonUserGroupController@create');
        $oRouter->post('user_group/save', 'CommonUserGroupController@save');
        $oRouter->post('user_group/delete', 'CommonUserGroupController@delete');
        $oRouter->get('user_group/get_user_group_tree', 'CommonUserGroupController@getUserGroupTree');
        $oRouter->get('user_group/get_group_type', 'CommonUserGroupController@getGroupType');

        // 用户组角色管理
        $oRouter->get('user_group_role/list', 'CommonRoleUserGroupRelationController@index');
        $oRouter->get('user_group_role/get_list', 'CommonRoleUserGroupRelationController@getList');
        $oRouter->get('user_group_role/edit', 'CommonRoleUserGroupRelationController@edit');
        $oRouter->post('user_group_role/update', 'CommonRoleUserGroupRelationController@update');
        $oRouter->get('user_group_role/create', 'CommonRoleUserGroupRelationController@create');
        $oRouter->post('user_group_role/save', 'CommonRoleUserGroupRelationController@save');
        $oRouter->post('user_group_role/delete', 'CommonRoleUserGroupRelationController@delete');
        $oRouter->get('user_group_role/get_role_tree', 'CommonRoleUserGroupRelationController@getRoleTree');


        // 用户组用户管理
        $oRouter->get('user_group_user/list', 'UserGroupUserController@index');
        $oRouter->get('user_group_user/get_list', 'UserGroupUserController@getList');
        $oRouter->get('user_group_user/edit', 'UserGroupUserController@edit');
        $oRouter->post('user_group_user/update', 'UserGroupUserController@update');
        $oRouter->get('user_group_user/create', 'UserGroupUserController@create');
        $oRouter->post('user_group_user/save', 'UserGroupUserController@save');
        $oRouter->post('user_group_user/delete', 'UserGroupUserController@delete');;
        $oRouter->post('user_group_user/set_expire_time', 'UserGroupUserController@setExpireTime');;
        $oRouter->post('user_group_user/set_merge_perm', 'UserGroupUserController@mergePerm');;
        $oRouter->post('user_group_user/delete_user_group', 'UserGroupUserController@delUserGroup');;
        $oRouter->post('user_group_user/batch_set_user_group', 'UserGroupUserController@batchSetUserGroup');;
        $oRouter->get('user_group_user/get_user_group', 'UserGroupUserController@getUserGroup');;

        // 角色管理
        $oRouter->get('role/list', 'CommonRoleController@index');
        $oRouter->get('role/get_list', 'CommonRoleController@getList');
        $oRouter->get('role/edit', 'CommonRoleController@edit');
        $oRouter->post('role/update', 'CommonRoleController@update');
        $oRouter->get('role/create', 'CommonRoleController@create');
        $oRouter->post('role/save', 'CommonRoleController@save');
        $oRouter->post('role/delete', 'CommonRoleController@delete');
        $oRouter->get('role/get_role_tree', 'CommonRoleController@getRoleTree');

        // 角色菜单管理
        $oRouter->get('role_menu/list', 'CommonRoleMenuController@index');
        $oRouter->get('role_menu/get_list', 'CommonRoleMenuController@getList');
        $oRouter->get('role_menu/edit', 'CommonRoleMenuController@edit');
        $oRouter->post('role_menu/update', 'CommonRoleMenuController@update');
        $oRouter->get('role_menu/create', 'CommonRoleMenuController@create');
        $oRouter->post('role_menu/save', 'CommonRoleMenuController@save');
        $oRouter->post('role_menu/delete', 'CommonRoleMenuController@delete');

        // 资源管理
        $oRouter->get('resource/list', 'CommonResourceController@index');
        $oRouter->get('resource/get_list', 'CommonResourceController@getList');
        $oRouter->get('resource/edit', 'CommonResourceController@edit');
        $oRouter->post('resource/update', 'CommonResourceController@update');
        $oRouter->get('resource/create', 'CommonResourceController@create');
        $oRouter->post('resource/save', 'CommonResourceController@save');
        $oRouter->post('resource/delete', 'CommonResourceController@delete');

        // 菜单管理
        $oRouter->get('menu/list', 'CommonMenuController@index');
        $oRouter->get('menu/get_list', 'CommonMenuController@getList');
        $oRouter->get('menu/edit', 'CommonMenuController@edit');
        $oRouter->post('menu/update', 'CommonMenuController@update');
        $oRouter->get('menu/create', 'CommonMenuController@create');
        $oRouter->post('menu/save', 'CommonMenuController@save');
        $oRouter->post('menu/delete', 'CommonMenuController@delete');
        $oRouter->get('menu/get_menu_tree', 'CommonMenuController@getMenuTree');


        // 角色权限管理
        $oRouter->get('role_perm/list', 'CommonRolePermController@index');
        $oRouter->get('role_perm/get_list', 'CommonRolePermController@getList');
        $oRouter->get('role_perm/edit', 'CommonRolePermController@edit');
        $oRouter->post('role_perm/update', 'CommonRolePermController@update');
        $oRouter->get('role_perm/create', 'CommonRolePermController@create');
        $oRouter->post('role_perm/save', 'CommonRolePermController@save');
        $oRouter->post('role_perm/delete', 'CommonRolePermController@delete');
    });


});