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

    public static function getResourceByController($sController)
    {
        $oResource = CommonResource::where('iType', self::SOURCE_TYPE_NAMESPACE )
            ->where('iBusinessType', 1)
            ->where('sControllerName', $sController)
            ->where('iShow', 1)
            ->first();
        return $oResource == null ? [] : $oResource->toArray();
    }
}