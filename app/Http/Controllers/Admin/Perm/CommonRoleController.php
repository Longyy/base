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
use App\Modules\Perm\CommonUserGroupModules;
use Illuminate\Http\Request;
use App\Modules\Perm\CommonRoleModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class CommonRoleController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        $aGroupType = CommonRoleModules::getRoleType();
        return view('admin.perm.role-list', [
            'data' => [
                'role_type' => $aGroupType,
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
            'iType' => 'integer|min:1',
        ]);
        $aResult = CommonRole::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            CommonRole::columns(),
            CommonRole::orders(),
            CommonRole::ranges()
        )->toArray();
        $aRoleType = CommonRoleModules::getRoleType();
        $aResult['data'] = array_map(function($aVal) use ($aRoleType) {
            $aVal['sType'] = isset($aRoleType[$aVal['iType']]) ? $aRoleType[$aVal['iType']] : '';
            return $aVal;
        }, $aResult['data']);
        $aResult['data'] = CommonUserGroupModules::buildGroupTree($aResult['data'], [], 1, 0);
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

        $oCommonRole = CommonRole::find($aFieldValue['iAutoID']);
        $aRoleType = CommonRoleModules::getRoleType();

        return view('admin.perm.role-edit', [
            'data' => [
                'role' => $oCommonRole->toArray(),
                'role_type' => $aRoleType,
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
            'iParentID' => 'required|integer',
        ]);

        if(is_null($oRole = CommonRole::find($aFieldValue['iAutoID']))) {
            return Response::exceptionMobi(new MobiException('ROLE_NOT_EXIST'));
        }

        if($aFieldValue['iParentID']) {
            if(is_null( $oParentRole = CommonRole::find($aFieldValue['iParentID']))) {
                return Response::exceptionMobi(new MobiException('PARENT_ROLE_NOT_EXIST'));
            }
            $aFieldValue['iLevel'] = $oParentRole->iLevel + 1;
            $aFieldValue['sRelation'] = sprintf('%s%s,', $oParentRole->sRelation, $aFieldValue['iAutoID']);
        } else {
            $aFieldValue['iLevel'] = 1;
            $aFieldValue['sRelation'] = sprintf(',%s,', $oRole->iAutoID);
        }

        if(! $oRole->update($aFieldValue)) {
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
        return view('admin.perm.role-add', [
            'data' => [
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
            'sName' => 'required|string|min:1|unique:common_role,sName',
            'iType' => 'integer|min:1',
            'iParentID' => 'integer|min:0',
        ]);

        if($aFieldValue['iParentID']) {
            if(is_null( $oRole = CommonRole::find($aFieldValue['iParentID']))) {
                return Response::exceptionMobi(new MobiException('PARENT_ROLE_NOT_EXIST'));
            }
        }

        if(! ($oNewRole = CommonRole::create($aFieldValue))) {
            return Response::exceptionMobi(new MobiException('CREATE_ERROR'));
        }

        if(!empty($oRole)) {
            $oNewRole->iLevel = $oRole->iLevel + 1;
            $oNewRole->sRelation = sprintf('%s%s,', $oRole->sRelation, $oNewRole->iAutoID);
        } else {
            $oNewRole->iLevel = 1;
            $oNewRole->sRelation = sprintf(',%s,', $oNewRole->iAutoID);
        }

        if(! $oNewRole->save()) {
            return Response::exceptionMobi(new MobiException('UPDATE_ERROR'));
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
        if(! CommonRole::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
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