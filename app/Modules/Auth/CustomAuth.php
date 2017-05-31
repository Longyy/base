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
        // 初始化用户信息
        $this->aUser = $this->user();
        // 初始化用户组信息
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

    /**
     * 设置用户组信息
     * @return bool
     */
    private function setUserGroup()
    {
        $aGroup = [];
        $oUserGroup = UserGroup::getUserGroup($this->getUserID());
        if(count($oUserGroup)) {
            foreach($oUserGroup as $oGroup) {
                $aGroup[] = [
                    'iGroupID' => $oGroup->iGroupID,
                    'sGroupName' => $oGroup->sGroupName,
                    'iGroupType' => $oGroup->iGroupType,
                    'iExpireTime' => $oGroup->iExpireTime,
                    'iPrepend' => $oGroup->iPrepend,
                ];
            }
        }
        $this->aUser['aGroup'] = $aGroup;
        return true;
    }

    public function getMainGroupID()
    {
        return $this->aUser['iGroupID'];
    }

    private function getGroupInfo()
    {
        return $this->aUser['aGroup'];
    }


    public function getPrependGroupIDs()
    {
        return array_column(
            array_where($this->getGroupInfo(), function($sKey, $aValue) {
            return $aValue['iPrepend'] ? true : false;
        }), 'iGroupID');

    }

    public function getAllPermGroupIDs()
    {
        return array_merge([$this->getCurrentGroupID()], $this->getPrependGroupIDs());
    }

    public function getCurrentGroupID()
    {
        return $this->aUser['iCurrentGroupID'];
    }

    public function getUserID()
    {
        return $this->aUser['iAutoID'];
    }
}