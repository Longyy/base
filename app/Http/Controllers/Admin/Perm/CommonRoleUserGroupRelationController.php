<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\RootController as Controller;
use App\Models\Perm\CommonRole;
use App\Models\Perm\CommonRoleUserGroupRelation;
use App\Modules\Perm\CommonRoleModules;
use App\Modules\Perm\CommonUserGroupModules;
use Illuminate\Http\Request;
use App\Modules\Perm\UserGroupModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class CommonRoleUserGroupRelationController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        $aGroupType = UserGroupModules::getGroupType();
        return view('admin.perm.user-group-role-list', [
            'data' => [
                'group_type' => $aGroupType,
            ]
        ]);
    }

    /**
     * 获取列表数据
     * @param Request $oRequest
     * @return mixed
     */
    public function getList(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'page_size' => 'integer|min:1',
            'iGroupID' => 'integer|min:1',
        ]);
        $aResult = CommonRoleUserGroupRelation::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            CommonRoleUserGroupRelation::columns(),
            CommonRoleUserGroupRelation::orders(),
            CommonRoleUserGroupRelation::ranges()
        )->toArray();
        $aGroupID = array_unique(array_column(array_get($aResult, 'data', []), 'iGroupID'));
        $aGroupInfo = CommonUserGroupModules::getGroupName($aGroupID);
        $aRoleID = array_unique(array_column(array_get($aResult, 'data', []), 'iRoleID'));
        $aRoleInfo = CommonRoleModules::getRoleName($aRoleID);
        $aResult['data'] = array_map(function($aVal) use ($aGroupInfo, $aRoleInfo) {
            $aVal['sGroupName'] = isset($aGroupInfo[$aVal['iGroupID']]) ? $aGroupInfo[$aVal['iGroupID']]['sName'] : '';
            $aVal['sRoleName'] = isset($aRoleInfo[$aVal['iRoleID']]) ? $aRoleInfo[$aVal['iRoleID']]['sName'] : '';
            return $aVal;
        }, $aResult['data']);

        return Response::mobi($aResult);
    }

    /**
     * 编辑页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'iAutoID' => 'required|integer',
        ]);

        $oUserGroupRole = CommonRoleUserGroupRelation::find($aFieldValue['iAutoID']);
        $aGroupInfo = CommonUserGroupModules::getGroupName([$oUserGroupRole['iGroupID']]);
        $oUserGroupRole->sGroupName = $aGroupInfo[$oUserGroupRole['iGroupID']]['sName'];
        $oRole = CommonRole::find($oUserGroupRole->iRoleID);
        $oUserGroupRole->iRoleType = $oRole->iType;

        return view('admin.perm.user-group-role-edit', [
            'data' => [
                'user_group_role' => $oUserGroupRole->toArray(),
                'role_type' => CommonRoleModules::getRoleType(),
            ]]);
    }

    /**
     * 更新
     * @param Request $oRequest
     * @return mixed
     */
    public function update(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'iAutoID' => 'required|integer',
            'iGroupID' => 'required|integer|min:1',
            'iRoleID' => 'required|integer|min:1',
        ]);
        if(! $oUserGroup = CommonRoleUserGroupRelation::find($aFieldValue['iAutoID'])) {
            return Response::exceptionMobi(new MobiException('RELATION_NOT_EXIST'));
        }

        if(CommonRoleUserGroupRelation::where(array_except($aFieldValue, 'iAutoID'))->count()) {
            return Response::exceptionMobi(new MobiException('RELATION_DUPLICATE'));
        }

        $oUserGroup->iRoleID = $aFieldValue['iRoleID'];
        if(! $oUserGroup->save()) {
            return Response::exceptionMobi(new MobiException('UPDATE_ERROR'));
        }

        return Response::mobi([]);
    }

    /**
     * 新增页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $oRequest)
    {
        return view('admin.perm.user-group-role-add', [
            'data' => [
                'group_type' => UserGroupModules::getGroupType(),
                'role_type' => CommonRoleModules::getRoleType(),
            ]]);
    }

    /**
     * 新增
     * @param Request $oRequest
     * @return mixed
     */
    public function save(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'iGroupID' => 'required|integer|min:1',
            'iRoleID' => 'required|integer|min:1',
        ]);
        if(CommonRoleUserGroupRelation::where($aFieldValue)->get()->toArray()) {
            return Response::exceptionMobi(new MobiException('RELATION_ALREADY_EXIST'));
        }
        if(! CommonRoleUserGroupRelation::create($aFieldValue)) {
            return Response::exceptionMobi(new MobiException('CREATE_ERROR'));
        }

        return Response::mobi([]);
    }

    /**
     * 删除
     * @param Request $oRequest
     * @return mixed
     */
    public function delete(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'sAutoID' => 'required|string|min:1',
        ]);
        if(! CommonRoleUserGroupRelation::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }

    public function getRoleTree(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'iRoleType' => 'required|integer|min:1',
            'iRoleID' => 'integer|min:0',
        ]);
        return Response::mobi(CommonRoleModules::getRoleTree($aFieldValue['iRoleType'], array_get($aFieldValue, 'iRoleID', 0)));
    }

}