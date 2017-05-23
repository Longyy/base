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

/**
 * 处理页面公共数据
 * Class GlobalComposer
 * @package App\Http\ViewComposers
 */
class GlobalComposer
{
    protected $oUser;

    public function __construct()
    {
    }

    public function compose(View $oView)
    {
        dd('xx');
        // 用户信息
        $iUserGroupID = 1;
        $oView->with('aPageMenu', PermModules::getPageMenu($iUserGroupID));
        // 菜单信息

        // 站点信息

        
    }
}