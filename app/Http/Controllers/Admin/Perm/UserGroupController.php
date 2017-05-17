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
        $this->validate($oRequest, [
            'sName' => 'string|max:20',
        ]);
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
        if($oUserGroup->update($oRequest->all())) {
            $aResult = [
                'code' => 0,
                'msg' => '更新成功！',
            ];
        } else {
            $aResult = [
                'code' => 1,
                'msg' => '更新失败！',
            ];
        }
        return Response::json($aResult);
    }

    public function create(Request $oRequest)
    {
        $aGroupType = UserGroupModules::getGroupType();

        return view('admin.perm.user-group-add', [
            'data' => [
                'group_type' => $aGroupType,
            ]]);
    }

    public function save(Request $oRequest)
    {
        $this->validate($oRequest, [
            'sName' => 'required|string|min:1|unique:common_usergroup,sName',
            'iType' => 'integer',
        ]);

        if(CommonUserGroup::create($oRequest->all())) {
            $aResult = [
                'code' => 0,
                'msg' => '新增成功！',
            ];
        } else {
            $aResult = [
                'code' => 1,
                'msg' => '新增失败！',
            ];
        }
        return Response::json($aResult);
    }

    public function delete(Request $oRequest)
    {
        $this->validate($oRequest, [
            'sAutoID' => 'required|string|min:1',
        ]);
        if(CommonUserGroup::whereIn('iAutoID', explode(',', $oRequest->input('sAutoID')))->delete()) {
            $aResult = [
                'code' => 0,
                'msg' => '删除成功！',
            ];
        } else {
            $aResult = [
                'code' => 1,
                'msg' => '删除失败！',
            ];
        }
        return Response::json($aResult);
    }

}