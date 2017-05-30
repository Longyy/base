<?php
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/4/25
 * Time: 22:44
 */

namespace App\Modules\Auth;

use App\Contracts\Auth\Auth;
use App\Models\Perm\UserGroup;
use App\Models\User;
use Request;

class CustomAuth implements Auth
{
    public $aUser = [];
    public function __construct()
    {
        $this->aUser = $this->user();
        $this->setUserGroup();
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

    private function setUserGroup()
    {
        $aGroup = [];
        $oUserGroup = UserGroup::getUserGroup($this->getUserID());
        if(is_array($oUserGroup)) {
            $aUserGroup = $oUserGroup->toArray();
            dd($aUserGroup);
        }


    }

    public function getMainGroupID()
    {
        return $this->aUser['iGroupID'];
    }


    public function getUserGroups()
    {

    }

    public function getUserID()
    {
        return $this->aUser['iAutoID'];
    }
}