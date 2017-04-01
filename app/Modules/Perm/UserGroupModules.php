<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/30
 * Time: 21:09
 */

namespace App\Modules\Perm;


class UserGroupModules
{
    private static $aGroupType = [
        1 => '系统用户组',
        2 => '普通用户组',
        3 => '特殊用户组',
    ];

    public static function getGroupType()
    {
        return self::$aGroupType;
    }
}