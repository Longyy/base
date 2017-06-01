<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\RootController;
use App\Modules\Auth\UserModules;
use Request;
use CustomAuth;
class IndexController extends RootController
{
    public function index(Request $oRequest)
    {
        return view('admin.index');
    }

    public function changeGroup(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'group_id' => 'required|uint32',
        ]);
        if(CustomAuth::changeGroup($aFieldValue['group_id'])) {
            redirect(UserModules::getHomeUrl());
        } else {
            back();
        }
    }
}