<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/31
 * Time: 23:28
 */

namespace App\Modules\Perm;


use App\Models\Perm\CommonResource;

class CommonResourceModules
{
    const SOURCE_TYPE_NAMESPACE = 1;
    const SOURCE_TYPE_PATH = 2;

    const BUSINESS_TYPE_WEB = 1;

    private static $aResourceType = [
        1 => '命名空间',
        2 => '路径',
    ];

    private static $aResourceBusinessType = [
        1 => '通用后台管理',
        2 => 'c端业务',
    ];

    public static function getResourceByController($sController, $sAction = '')
    {
        $oResource = CommonResource::where('iType', self::SOURCE_TYPE_NAMESPACE )
            ->where('iBusinessType', self::getBusinessType())
            ->where('sControllerName', $sController)
            ->where('sFunctionName', $sAction)
            ->where('iShow', 1)
            ->first();
        return $oResource == null ? [] : $oResource->toArray();
    }

    /**
     * 取业务类型
     * @return int
     */
    public static function getBusinessType()
    {
        switch(env('APP_NAME', '')) {
            case 'base-web':
                $iType = self::BUSINESS_TYPE_WEB;
                break;
            default:
                $iType = 0;
                break;
        }
        return $iType;
    }

    public static function getResourceType()
    {
        return self::$aResourceType;
    }

    public static function getResourceBusinessType()
    {
        return self::$aResourceBusinessType;
    }
}