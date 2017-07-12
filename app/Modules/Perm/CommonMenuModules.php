<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/30
 * Time: 22:50
 */

namespace App\Modules\Perm;


use App\Models\Perm\CommonMenu;

class CommonMenuModules
{
    private static $aMenuTypeMap = [
        1 => '菜单',
        2 => '按钮',
    ];
    public static function getMenuInfoByID($aMenuID)
    {
        $oMenuInfo = CommonMenu::whereIn('iAutoID', $aMenuID)
            ->where('iShow', 2)
            ->orderBy('iBusinessType', 'asc')
            ->orderBy('iLevel', 'asc')
            ->get();
        return count($oMenuInfo) ? $oMenuInfo->toArray() : [];
    }

    public static function getPathKey()
    {
        switch(env('APP_NAME', '')) {
            case 'base-web':
                $sKey = CommonMenu::$sWebPathKey;
                break;
            default:
                $sKey = '';
                break;
        }
        return $sKey;
    }

    public static function getMenuType()
    {
        return self::$aMenuTypeMap;
    }

    public static function getMenuTree($iType, $iBusinessID, $iCheckID = 0)
    {
        $aMenuInfo = CommonMenu::select('iAutoID', 'iParentID', 'iLevel', 'sName')
            ->where('iType', $iType)
            ->where('iBusinessType', $iBusinessID)
            ->orderBy('iLevel', 'asc')
            ->orderBy('iAutoID', 'asc')
            ->get()
            ->toArray();
        return self::formatMenuTree($aMenuInfo, [], 1, 0, $iCheckID);
    }

    public static function formatMenuTree($aData, $aRes, $iLevel, $iParentID, $iCheckID = 0)
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
                        $aTree['nodes'] = self::formatMenuTree($aData, [], $iLevel + 1, $aVal['iAutoID'], $iCheckID);
                        $aTree['tags'] = [count($aTree['nodes'])];
                    }
                }
                $aRes[] = $aTree;
            }
        }
        return $aRes;
    }
}