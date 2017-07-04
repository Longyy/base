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
}