<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
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
    public function postLogin(array $oRequest = [])
    {
        dd($oRequest);
        $aField = $this->validate($oRequest, [

        ]);
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