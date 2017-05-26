<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/26
 * Time: 21:07
 */

namespace App\Facades\Auth;


use Illuminate\Support\Facades\Facade;

class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'customauth';
    }

}