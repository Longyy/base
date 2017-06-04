<?php
/**
 * Created by PhpStorm.
 * UserModules: LONGYONGYU
 * Date: 2017/5/23
 * Time: 21:45
 */
return [

    'Estate\Exceptions\ValidateException' => [
        'VALIDATE_FAILS' => ['请求参数验证失败', '1000'],
    ],

    'Estate\Exceptions\ServiceException' => [
        'SERVICE_SYSTEM_ERROR'       => ['服务层系统异常','511'],
    ],

    'Estate\Exceptions\WebException' => [
        // 2000 - 10000
        'USER_NOT_EXIST' => ['用户不存在', '2000'],
        'USER_OR_PASSWORD_ERROR' => ['用户名或密码错误', '2001'],
    ],

    'Estate\Exceptions\MobiException' => [
        //  10001 - 20000
        'CHANGE_GROUP_ERROR' => ['切换用户组失败', '10001'],
        'UPDATE_ERROR' => ['更新失败', '10002'],
        'UPDATE_SUCCESS' => ['更新成功', '10003'],
        'CREATE_ERROR' => ['创建失败', '10004'],
        'DELETE_ERROR' => ['删除失败', '10005'],
    ],
];