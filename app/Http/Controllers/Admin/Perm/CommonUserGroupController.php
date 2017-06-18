<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\RootController as Controller;
use App\Http\Helpers\Tools;
use App\Modules\Perm\CommonUserGroupModules;
use Illuminate\Http\Request;
use App\Models\Perm\CommonUserGroup;
use App\Modules\Perm\UserGroupModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class CommonUserGroupController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        $aGroupType = UserGroupModules::getGroupType();
        return view('admin.perm.user-group-list', [
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
            'iType' => 'integer|min:1',
        ]);
        $aResult = CommonUserGroup::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            CommonUserGroup::columns(),
            CommonUserGroup::orders(),
            CommonUserGroup::ranges()
        )->toArray();
        $aGroupType = UserGroupModules::getGroupType();
        $aResult['data'] = array_map(function($aVal) use ($aGroupType) {
            $aVal['sType'] = isset($aGroupType[$aVal['iType']]) ? $aGroupType[$aVal['iType']] : '';
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

        $oUserGroup = CommonUserGroup::find($aFieldValue['iAutoID']);
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
            'iParentID' => 'integer'
        ]);
        if(! is_null( $oUserGroup = CommonUserGroup::find($aFieldValue['iAutoID']))) {
            Log::info('not null');
            $oUserGroup->iType = $aFieldValue['iType'];
            $oUserGroup->sName = trim($aFieldValue['sName']);
            if(array_get($aFieldValue, 'iParentID') > 0) {
                if (!is_null($oParent = CommonUserGroup::find($aFieldValue['iParentID']))) {
                    Log::info('parent not null');
                    $oUserGroup->iParentID = $aFieldValue['iParentID'];
                    $oUserGroup->iLevel = $oParent->iLevel + 1;
                    $oUserGroup->sRelation = Tools::addLeafNode($oParent['sRelation'], $aFieldValue['iAutoID']);
                } else {
                    return Response::exceptionMobi(new MobiException('PARENT_GROUP_NOT_EXIST'));
                }
            } else {
                $oUserGroup->iParentID = 0;
                $oUserGroup->iLevel = 1;
                $oUserGroup->sRelation = '';
            }
            if (!$oUserGroup->save()) {
                return Response::exceptionMobi(new MobiException('UPDATE_ERROR'));
            }
        } else {
            Log::info('null');
            return Response::exceptionMobi(new MobiException('USER_GROUP_NOT_EXIST'));
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
        if(! CommonUserGroup::create($aFieldValue)) {
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
        if(! CommonUserGroup::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }

    public function getUserGroupTree(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'iGroupType' => 'required|integer|min:1',
            'iGroupID' => 'integer|min:0',
        ]);
        return Response::mobi(CommonUserGroupModules::getGroupTree($aFieldValue['iGroupType'], array_get($aFieldValue, 'iGroupID', 0)));
    }

}