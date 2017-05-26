<?php
namespace App\Http\Controllers\Auth;

use App\Modules\Auth\UserModules;
use Illuminate\Http\Request;
use Estate\Exceptions\WebException;
use App\Http\Controllers\RootController;

class AuthController extends RootController
{
    /**
     * 登录页面
     * @param Request $oRequest
     */
    public function getLogin(Request $oRequest)
    {
       return view('auth.login');
    }

    /**
     * 提交登录
     * @param Request $oRequest
     */
    public function postLogin(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest,[
            'username' => 'required|string|max:20',
            'password' => 'required|string',
            'remember' => 'string|max:2',
        ], [
            'username.required' => '姓名必填',
            'password.required' => '密码必填',
        ]);
        return redirect(UserModules::postLogin($aFieldValue, $oRequest)
            ? UserModules::getHomeUrl() : UserModules::getLoginUrl());
    }

    /**
     * 登出
     * @param Request $oRequest
     */
    public function getLogout(Request $oRequest)
    {

    }

    /**
     * 注册页面
     * @param Request $oRequest
     */
    public function getRegister(Request $oRequest)
    {

    }

    /**
     * 提交注册
     * @param Request $oRequest
     */
    public function postRegister(Request $oRequest)
    {
    }
}