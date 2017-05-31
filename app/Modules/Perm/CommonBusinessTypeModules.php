<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/31
 * Time: 16:55
 */

namespace App\Modules\Perm;
use App\Http\Helpers\Tools;
use App\Models\Perm\CommonBusinessType;
use Cache;

class CommonBusinessTypeModules
{
    const BUSINESS_TYPE_CONFIG_KEY = 'BASE:BUSINESS_TYPE_CONFIG';
    const EXPIRE_TIME = 360; // 360分钟
    public static function getBusinessType($iType = 0)
    {
        return Cache::remember(self::BUSINESS_TYPE_CONFIG_KEY, self::EXPIRE_TIME, function() {
            $aConfig = CommonBusinessType::select('iAutoID', 'sName', 'sDomain')->get();
            return count($aConfig) ? Tools::useFieldAsKey($aConfig->toArray(), 'iAutoID') : [];
        });
    }
}