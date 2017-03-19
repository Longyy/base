<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13
 * Time: 22:03
 */

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class ProfileComposer
{
    public function __construct()
    {

    }

    public function compose(View $oView)
    {

        $oView->with('aProfile', [2]);
    }
}