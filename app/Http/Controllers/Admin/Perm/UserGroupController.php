<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perm\CommonUserGroup;
use App\Modules\Perm\UserGroupModules;
use Response;

class UserGroupController extends Controller
{
    public function index(Request $oRequest)
    {
        return view('admin.perm.user-group-list');
    }

    public function getList(Request $oRequest)
    {
        $data = CommonUserGroup::all()->toArray();
        return Response::json(['total' => 6, 'rows' => $data]);
    }

    public function edit(Request $oRequest)
    {
        $this->validate($oRequest, [
            'iAutoID' => 'required|integer',
        ]);

        $oUserGroup = CommonUserGroup::find($oRequest->get('iAutoID'));
        $aGroupType = UserGroupModules::getGroupType();

        return view('admin.perm.user-group-edit', [
            'data' => [
                'user_group' => $oUserGroup->toArray(),
                'group_type' => $aGroupType,
            ]]);
    }

    public function update(Request $oRequest)
    {
        $this->validate($oRequest, [
            'iAutoID' => 'required|integer',
            'sName' => 'required|string|min:1',
            'iType' => 'integer',
        ]);

        $oUserGroup = CommonUserGroup::find($oRequest->get('iAutoID'));
        $mResult = $oUserGroup->save($oRequest->all());

    }
}