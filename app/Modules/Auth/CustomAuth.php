<?php
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/4/25
 * Time: 22:44
 */

namespace App\Modules\Auth;

use App\Contracts\Auth\Auth;
use App\Models\User;
use Request;

class CustomAuth implements Auth
{
    public $aUser = [];
    public function __construct()
    {
        $this->aUser = $this->user();
    }

    public function guest()
    {
        return $this->aUser ? false : true;
    }

    public function check()
    {

    }

    public function user()
    {
        // session
        if(! ($aUser = UserModules::getSessionUser())) {
            // remember token
            if(! ($aUser = UserModules::getRememberTokenUser())) {
                // global token @todo
            }
        }
        return $aUser ?: [];
    }

    public function getMainGroupID()
    {
        return $this->aUser['iGroupID'];
    }
}