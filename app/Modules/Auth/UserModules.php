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
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Cookie;

class UserModules
{
    const REMEMBER_ME = 'on'; // 记住我
    const REMEMBER_EXIPRE_TIME = 100; // 分钟


    public static function postLogin($aParam, $oRequest)
    {
//        dd(bcrypt(123));
        // 用户名
        if($oUser = User::getUserByName($aParam['username'])) {
            // 密码
            if(bcrypt($aParam['password']) != $oUser->sPassword) {
                // session
                $oRequest->session()->put('user', $oUser->toArray());
                // 记住我
                if(self::REMEMBER_ME == array_get($aParam, 'remember', '')) {
                    // 生成token
                    $sRememberToken = Str::random(60);
                    // 保存在数据
                    if($oUser->update(['sRememberToken' => $sRememberToken])) {
                        // 发送给客户端
                        Cookie::queue('remember_token', $sRememberToken, self::REMEMBER_EXIPRE_TIME);
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
}