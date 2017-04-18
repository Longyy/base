<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13
 * Time: 22:03
 */

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Modules\Perm\ProfileModules;
use Auth;

class ProfileComposer
{
    protected $oUser;

    public function __construct()
    {
        $this->oUser = Auth::user();
    }

    public function compose(View $oView)
    {

        $oView->with('aProfile', ProfileModules::getProfile($this->oUser));
    }
}