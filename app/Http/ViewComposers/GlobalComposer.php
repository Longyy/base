<?php
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/5/17
 * Time: 21:48
 */

namespace App\Http\ViewComposers;

use App\Modules\Perm\PermModules;
use Illuminate\Contracts\View\View;
use CustomAuth;
/**
 * 处理页面公共数据
 * Class GlobalComposer
 * @package App\Http\ViewComposers
 */
class GlobalComposer
{
    public function __construct()
    {
    }

    public function compose(View $oView)
    {
        // 用户信息
        $oView->with('aProfile', [
            'sName' => CustomAuth::getUserInfo()['sName'],
            'sGroupName' => CustomAuth::getCurrentGroupName(),
            'aTempGroup' => CustomAuth::getAvailableGroup(),
        ]);
        // 菜单信息
        $oView->with('aPageMenu', PermModules::getPageMenu());
        // 站点信息

        
    }
}