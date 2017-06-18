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
use Log;

class CommonUserGroupModules
{
    private static $aGroupType = [
        1 => '系统用户组',
        2 => '普通用户组',
        3 => '特殊用户组',
        4 => '扩展用户组',
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

    public static function getGroupTree($iGroupType, $iGroupID = 0)
    {
        $aGroupInfo = CommonUserGroup::select('iAutoID', 'iParentID', 'iLevel', 'sName')
            ->where('iType', $iGroupType)
            ->orderBy('iLevel', 'asc')
            ->orderBy('iAutoID', 'asc')
            ->get()
            ->toArray();
        return self::formatGroupTree($aGroupInfo, [], 1, 0, $iGroupID);
    }

    public static function formatGroupTree($aData, $aRes, $iLevel, $iParentID, $iCheckID = 0)
    {
        $aData1 = $aData;
        foreach($aData as $aVal) {
            $aTree = [];
            if($aVal['iLevel'] == $iLevel && $aVal['iParentID'] == $iParentID) {
                $aTree['text'] = $aVal['sName'];
                $aTree['id'] = $aVal['iAutoID'];
                if($iCheckID && $iCheckID == $aVal['iAutoID']) {
                    $aTree['state']['checked'] = true;
                    $iCheckID = 0;
                }
                foreach($aData1 as $aVVal) {
                    if($aVVal['iLevel'] == ($iLevel + 1) && $aVVal['iParentID'] == $aVal['iAutoID']) {
                        $aTree['nodes'] = self::formatGroupTree($aData, [], $iLevel + 1, $aVal['iAutoID'], $iCheckID);
                        $aTree['tags'] = [count($aTree['nodes'])];
                    }
                }
                $aRes[] = $aTree;
            }
        }
        return $aRes;
    }

    public static function buildGroupTree($aData, $aRes, $iLevel, $iParentID)
    {
        foreach($aData as $aVal) {
            $bFlag = false;
            if($aVal['iLevel'] == $iLevel && $aVal['iParentID'] == $iParentID) {
                $aRes[] = $aVal;
                $bFlag = true;
            }
            if($bFlag) {
                $aRes = self::buildGroupTree($aData, $aRes, $iLevel + 1, $aVal['iAutoID']);
            }
        }
        return $aRes;
    }
}