<?php
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/3/30
 * Time: 21:09
 */

namespace App\Modules\Perm;

use App\Http\Helpers\Tools;
use App\Models\Perm\CommonUserGroup;

class CommonUserGroupModules
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

    public static function getGroupName($aGroupID)
    {
        $oGroupInfo = CommonUserGroup::whereIn('iAutoID', $aGroupID)->select('iAutoID', 'sName')->get();
        return $oGroupInfo == null ? [] : Tools::useFieldAsKey($oGroupInfo->toArray(), 'iAutoID');
    }
}