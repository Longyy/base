<?php
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/4/10
 * Time: 21:59
 */

namespace App\Modules\Perm;

use App\Models\Perm\CommonUserGroup;
use App\Models\Perm\UsersGroup;

class ProfileModules
{
    public static function getProfile($oUser)
    {
        if(!$oUser) {
            return [];
        }
        // 所属用户组
        $oGroup = CommonUserGroup::find($oUser->groupid);
        // 临时用户组
        $oTempGroup = UsersGroup::select('*')
            ->where('iUserID', $oUser->id)
            ->where('iExpireTime', '>=', time())
            ->where('iGroupType', UsersGroup::GROUP_TYPE_TEMP)
            ->where('iStatus', 1)
            ->get()
            ->toArray();
        $aGroup = array_map(function($aItem) {
            return array_only($aItem, ['iGroupID', 'sGroupName', 'iExpireTime']);
        }, $oTempGroup);
        return [
            'sName' => $oUser->name,
            'sGroupName' => $oGroup->sName,
            'aTempGroup' => $aGroup,
        ];
    }
}