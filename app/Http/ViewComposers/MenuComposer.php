<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13
 * Time: 21:58
 */
namespace App\Http\ViewComposers;

use App\Modules\Perm\PermModules;
use Illuminate\Contracts\View\View;
use Auth;

class MenuComposer
{
    protected $oUser;

    public function __construct()
    {
        $this->oUser = Auth::user();
    }

    public function compose(View $oView)
    {
        $iUserGroupID = 1;
        $oView->with('aPageMenu', PermModules::getPageMenu($iUserGroupID));
    }
}