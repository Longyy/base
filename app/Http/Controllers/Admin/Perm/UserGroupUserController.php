<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\RootController as Controller;
use App\Models\Perm\UserGroup;
use Illuminate\Http\Request;
use App\Modules\Perm\UserGroupModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class UserGroupUserController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        $aGroupType = UserGroupModules::getGroupType();
        return view('admin.perm.user-group-user-list', [
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
            'iUserGroupType' => 'integer|min:0',
        ]);
        if(!isset($aFieldValue['iUserGroupType'])) {
            $aFieldValue['iUserGroupType'] = 1;
        }

        return UserGroupModules::getUserList($aFieldValue);
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

        $oUserGroup = UserGroup::find($aFieldValue['iAutoID']);
        $aGroupType = UserGroupModules::getGroupType();

        return view('admin.perm.user-group-edit', [
            'data' => [
                'user_group' => $oUserGroup->toArray(),
                'group_type' => $aGroupType,
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
            'sName' => 'required|string|min:1',
            'iType' => 'required|integer',
        ]);

        $oUserGroup = UserGroup::find($aFieldValue['iAutoID']);
        Log::info('update ', [$aFieldValue]);
        if(! $oUserGroup->update($aFieldValue)) {
            Log::info('update result ', [false]);

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
        return view('admin.perm.user-group-add', [
            'data' => [
                'group_type' => UserGroupModules::getGroupType(),
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
            'sName' => 'required|string|min:1|unique:common_usergroup,sName',
            'iType' => 'integer',
        ]);
        if(! UserGroup::create($aFieldValue)) {
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
        if(! UserGroup::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }

    /**
     * 设置过期时间
     * @param Request $oRequest
     * @return mixed
     */
    public function setExpireTime(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'sUserID' => 'required|string|min:1',
            'iGroupID' => 'required|integer|min:0',
            'iUserGroupType' => 'required|integer|min:0',
            'sExpireTime' => 'required|date',
        ]);
        return UserGroupModules::setExpireTime($aFieldValue);
    }

    /**
     * 合并权限
     * @param Request $oRequest
     * @return mixed
     */
    public function mergePerm(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'sUserID' => 'required|string|min:1',
            'iGroupID' => 'required|integer|min:0',
            'iUserGroupType' => 'required|integer|min:0',
            'iMergePerm' => 'required|integer|min:0',
        ]);
        return UserGroupModules::mergePerm($aFieldValue);
    }

}