<?php
/**
 * Created by PhpStorm.
 * UserModules: LONGYONGYU
 * Date: 2017/5/23
 * Time: 22:02
 */

namespace App\Modules\Auth;

use App\Models\User;
use Estate\Exceptions\WebException;
use Request;
use Cookie;
use Illuminate\Support\Str;

class UserModules
{
    const REMEMBER_EXPIRE_TIME = 100; // 分钟
    const REMEMBER_TOKEN_NAME  = 'remember_token'; // remember token name
    const SESSION_USER_KEY = 'user';

    private static $sHomeUrl = '/backend';
    private static $sLoginUrl = '/auth/login';


    public static function postLogin($aParam, $oRequest)
    {
//        dd(bcrypt(123));
        // 用户名
        if($oUser = User::getUserByName($aParam['username'])) {
            // 密码
            if(bcrypt($aParam['password']) != $oUser->sPassword) {
                // 初始化用户组
                $oUser = self::initCurrentGroup($oUser);
                // session
                $oRequest->session()->put(self::SESSION_USER_KEY, $oUser->toArray());
                // 记住我
                if(isset($aParam['remember'])) {
                    // 生成token
                    $sRememberToken = Str::random(60);
                    // 保存在数据
                    if($oUser->update(['sRememberToken' => $sRememberToken])) {
                        // 发送给客户端
                        Cookie::queue('remember_token', $sRememberToken, self::REMEMBER_EXPIRE_TIME);
                        return true;
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
    }

    private static function initCurrentGroup($oUser)
    {
        $oUser->iCurrentGroupID = $oUser->iGroupID;
        return $oUser;
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
        return Request::cookie()->get(self::REMEMBER_TOKEN_NAME);
    }

    public static function updateUserCurrentGroup($iUserID, $mValue)
    {
        if($oUser = User::find($iUserID)) {
            if($oUser->update(['iCurrentGroupID', $mValue])) {
                return true;
            }
        }
        return false;
    }

}