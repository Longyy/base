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
    private static $aRoleTypeMap = [
        CommonRole::ROLE_TYPE_COMMON => '通用',
        CommonRole::ROLE_TYPE_LINE1 => '业务线1',
    ];
    public static function getRoleName($aRoleID)
    {
        $oRoleInfo = CommonRole::whereIn('iAutoID', $aRoleID)->select('iAutoID', 'sName')->get();
        return $oRoleInfo == null ? [] : Tools::useFieldAsKey($oRoleInfo->toArray(), 'iAutoID');
    }

    /**
     * 取角色类型
     * @return array
     */
    public static function getRoleType()
    {
        return self::$aRoleTypeMap;
    }

    public static function getRoleTree($iRoleType, $iRoleID = 0)
    {
        $aGroupInfo = CommonRole::select('iAutoID', 'iParentID', 'iLevel', 'sName')
            ->where('iType', $iRoleType)
            ->orderBy('iLevel', 'asc')
            ->orderBy('iAutoID', 'asc')
            ->get()
            ->toArray();
        return self::formatRoleTree($aGroupInfo, [], 1, 0, $iRoleID);
    }

    public static function formatRoleTree($aData, $aRes, $iLevel, $iParentID, $iCheckID = 0)
    {
        $aData1 = $aData;
        foreach($aData as $aVal) {
            $aTree = [];
            if($aVal['iLevel'] == $iLevel && $aVal['iParentID'] == $iParentID) {
                $aTree['text'] = $aVal['sName'];
                $aTree['id'] = $aVal['iAutoID'];
                if($iCheckID && $aVal['iAutoID'] == $iCheckID) {
                    $aTree['state']['checked'] = true;
                    $iCheckID = 0;
                }
                foreach($aData1 as $aVVal) {
                    if($aVVal['iLevel'] == ($iLevel + 1) && $aVVal['iParentID'] == $aVal['iAutoID']) {
                        $aTree['nodes'] = self::formatRoleTree($aData, [], $iLevel + 1, $aVal['iAutoID'], $iCheckID);
                        $aTree['tags'] = [count($aTree['nodes'])];
                    }
                }
                $aRes[] = $aTree;
            }
        }
        return $aRes;
    }
}