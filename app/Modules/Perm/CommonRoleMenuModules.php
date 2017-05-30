<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/30
 * Time: 22:40
 */

namespace App\Modules\Perm;


use App\Models\Perm\CommonRoleMenu;

class CommonRoleMenuModules
{
    public static function getMenuIDByRoleIDs($aRoleID)
    {
        $oMenu = CommonRoleMenu::getMenuIDByRoleIDs($aRoleID);
        return count($oMenu) ? $oMenu->toArray() : [];
    }
}