<?php
/**
 * Created by PhpStorm.
 * UserModules: LONGYONGYU
 * Date: 2017/5/23
 * Time: 22:02
 */

namespace App\Modules\Auth;

use App\Models\Perm\UserGroup;
use App\Models\User;
use Estate\Exceptions\WebException;
use Request;
use Cookie;

use Illuminate\Support\Str;
use Log;

class UserModules
{
    const REMEMBER_EXPIRE_TIME = 100; // 分钟
    const REMEMBER_TOKEN_NAME  = 'remember_token'; // remember token name
    const SESSION_USER_KEY = 'user';

    private static $sHomeUrl = '/backend';
    private static $sLoginUrl = '/auth/login';


    public static function postLogin($aParam, $oRequest)
    {
        // 用户名
        if($oUser = User::getUserByName($aParam['username'])) {
            // 密码
            if(sha1($aParam['password']) === $oUser->sPassword) {
                // 设置用户组信息
                $aUser = $oUser->toArray();
                $aUser = self::initCurrentGroup($aUser);
                // session
                $oRequest->session()->put(self::SESSION_USER_KEY, $aUser);
                // 记住我
                if(isset($aParam['remember'])) {
                    // 生成token
                    $sRememberToken = Str::random(60);
                    // 保存在数据
                    if($oUser->update(['sRememberToken' => $sRememberToken])) {
                        // 发送给客户端
                        Cookie::queue('remember_token', $sRememberToken, self::REMEMBER_EXPIRE_TIME);
                    } else {
                        throw new WebException('REMEMBER_ERROR');
                    }
                }

            } else {
                throw new WebException('USER_OR_PASSWORD_ERROR');
            }
        } else {
            throw new WebException('USER_OR_PASSWORD_ERROR');
        }
        return true;
    }

    /**
     * 设置用户组信息
     * @param $oUser
     * @return mixed
     */
    public static function initCurrentGroup($aUser)
    {
        // 默认用户组为用户的主用户组
        if(empty($aUser['iCurrentGroupID'])) {
            $aUser['iCurrentGroupID'] = $aUser['iGroupID'];
        }
        $aGroup = [];
        // 取用户所属的其他用户组
        $oUserGroup = UserGroup::getUserGroup($aUser['iAutoID']);
        if(count($oUserGroup)) {
            foreach ($oUserGroup as $oGroup) {
                $aGroup[$oGroup->iGroupID] = [
                    'iGroupID' => $oGroup->iGroupID,
                    'sGroupName' => $oGroup->sGroupName,
                    'iGroupType' => $oGroup->iGroupType,
                    'iExpireTime' => $oGroup->iExpireTime,
                    'iPrepend' => $oGroup->iPrepend,
                    'iMain' => 0,
                ];
            }
            // 用户无权访问当前用户组或者用户组被合并，则取默认用户组
            if(!isset($aGroup[$aUser['iCurrentGroupID']])
                || $aGroup[$aUser['iCurrentGroupID']]['iPrepend'] == UserGroup::PREPEND_YES) {
                $aUser['iCurrentGroupID'] = $aUser['iGroupID'];
            }
        }

        $aUser['aGroup'] = $aGroup;

        return $aUser;
    }

    /**
     * 首页
     * @return string
     */
    public static function getHomeUrl()
    {
        return self::$sHomeUrl;
    }

    /**
     * 登录页
     * @return string
     */
    public static function getLoginUrl()
    {
        return self::$sLoginUrl;
    }

    public static function getSessionUser()
    {
        return Request::session()->get(self::SESSION_USER_KEY);
    }

    public static function setSessionUser($sKey, $sValue)
    {
        $aUser = self::getSessionUser();
        $aUser[$sKey] = $sValue;
        return Request::session()->put(self::SESSION_USER_KEY, $aUser);
    }

    public static function getRememberTokenUser()
    {
        $aUser = [];
        if($sToken = self::getRememberToken()) {
            if($oUser = User::getUserByToken($sToken)) {
                $aUser = $oUser->toArray();
            }
        }
        return $aUser;
    }

    public static function getRememberToken()
    {
        return Request::cookie(self::REMEMBER_TOKEN_NAME);
    }

    public static function updateUserCurrentGroup($iUserID, $mValue)
    {
        if($oUser = User::find($iUserID)) {
            $oUser->iCurrentGroupID = $mValue;
            if($oUser->save()) {
                return true;
            }
        }
        return false;
    }

}