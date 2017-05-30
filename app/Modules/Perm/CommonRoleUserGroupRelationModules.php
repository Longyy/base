<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/30
 * Time: 22:26
 */

namespace App\Modules\Perm;


use App\Models\Perm\CommonRoleUserGroupRelation;

class CommonRoleUserGroupRelationModules
{
    public static function getRoleIDByGroupIDs($aGroupID)
    {
        $oRole = CommonRoleUserGroupRelation::getRoleIDByGroupIDs($aGroupID);
        return count($oRole) ? $oRole->toArray() : [];
    }
}