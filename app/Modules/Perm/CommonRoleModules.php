<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/30
 * Time: 22:40
 */

namespace App\Modules\Perm;


use App\Models\Perm\CommonRole;
use App\Models\Perm\CommonRoleMenu;
use App\Http\Helpers\Tools;

class CommonRoleModules
{
    public static function getRoleName($aRoleID)
    {
        $oRoleInfo = CommonRole::whereIn('iAutoID', $aRoleID)->select('iAutoID', 'sName')->get();
        return $oRoleInfo == null ? [] : Tools::useFieldAsKey($oRoleInfo->toArray(), 'iAutoID');
    }
}