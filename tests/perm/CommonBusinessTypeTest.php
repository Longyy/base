<?php

/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/7/25
 * Time: 10:00
 */
use App\Modules\Perm\CommonBusinessTypeModules;
class CommonBusinessTypeTest extends TestCase
{

    public function testBusinessType()
    {
        $aSub = [
            1 => [
                'iAutoID' => 1,
                'sName' => '通用后台',
                'sDomain' => 'base.com'
            ]
        ];
        $this->assertArraySubset($aSub, CommonBusinessTypeModules::getBusinessType());
    }
}