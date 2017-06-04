<?php
/**
 * Created by PhpStorm.
 * UserModules: Administrator
 * Date: 2017/4/25
 * Time: 22:44
 */

namespace App\Modules\Auth;

use App\Contracts\Auth\Auth;
use App\Http\Helpers\Tools;
use App\Models\Perm\UserGroup;
use App\Models\User;
use Request;
use Log;

class CustomAuth implements Auth
{
    public $aUser = [];
    public function __construct()
    {
        // 初始化用户信息
        $this->aUser = $this->user();
    }

    /**
     * 判断用户是否是游客
     * @return bool
     */
    public function guest()
    {
        return $this->aUser ? false : true;
    }

    public function check()
    {

    }

    /**
     * 取用户基本信息
     * @return array
     */
    public function user()
    {
        // session
        if(! ($aUser = UserModules::getSessionUser())) {
            // remember token
            if(! ($aUser = UserModules::getRememberTokenUser())) {
                // 设置用户组
                $aUser = UserModules::initCurrentGroup($aUser);
                // 恢复session
                Request::session()->put(UserModules::SESSION_USER_KEY, $aUser);
                // global token @todo
            }
        }
        return $aUser ?: [];
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

    public function getCurrentGroupName()
    {
        $iGroupID = $this->getCurrentGroupID();
        if($iGroupID == $this->getMainGroupID()) {
            return $this->aUser['sGroupName'];
        } else {
            if(isset($this->aUser['aGroup'][$iGroupID])) {
                return $this->aUser['aGroup'][$iGroupID]['sGroupName'];
            } else {
                return '';
            }
        }
    }

    /**
     * 取可切换用户组
     */
    public function getAvailableGroup()
    {
        $iCurrentGroupID = $this->getCurrentGroupID();
        $aGroupInfo = $this->getGroupInfo();
        // 用户当前在临时用户组
        if(isset($aGroupInfo[$iCurrentGroupID])) {
            $aGroupInfo = array_where($aGroupInfo, function($sKey, $aValue) use ($iCurrentGroupID) {
                return  $iCurrentGroupID != $sKey && $aValue['iPrepend'] == UserGroup::PREPEND_NO ? true : false;
            });
            $aGroupInfo[$this->aUser['iGroupID']] = [
                'iGroupID' => $this->aUser['iGroupID'],
                'sGroupName' => $this->aUser['sGroupName'],
                'iGroupType' => 0,
                'iExpireTime' => 0,
                'iPrepend' => 0,
                'iMain' => 1,
            ];
        }
        return $aGroupInfo;
    }

    public function getUserID()
    {
        return $this->aUser['iAutoID'];
    }

    public function getUserInfo()
    {
        return $this->aUser;
    }

    public function changeGroup($iGroupID)
    {
        // 用户已处在该用户组
        if($this->getCurrentGroupID() == $iGroupID) {
            return true;
        }
        // 用户无权限访问该用户组
        if(!isset($this->getAvailableGroup()[$iGroupID])) {
            return false;
        }
        // 切换用户组
        return UserModules::updateUserCurrentGroup($this->getUserID(), $iGroupID);
    }



}