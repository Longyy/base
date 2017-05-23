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
    ]
];