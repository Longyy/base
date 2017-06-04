<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\RootController;
use App\Modules\Auth\UserModules;
use Estate\Exceptions\MobiException;
use Illuminate\Http\Request;
use Response;
use CustomAuth;
use Log;
class IndexController extends RootController
{
    public function index(Request $oRequest)
    {
        return view('admin.index');
    }

    public function changeGroup(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'group_id' => 'required|integer',
        ]);
        if(CustomAuth::changeGroup($aFieldValue['group_id'])) {
            return Response::mobi(['url' => UserModules::getLoginUrl()]);
        }
        return Response::exceptionMobi(new MobiException('CHANGE_GROUP_ERROR'));
    }
}