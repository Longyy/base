<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13
 * Time: 19:23
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\RootController as Controller;
use App\Models\Perm\CommonUserGroup;
use App\Models\User;
use App\Modules\Perm\CommonUserGroupModules;
use App\Modules\Perm\UserGroupModules;
use Illuminate\Http\Request;
use Response;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.perm.user-list');
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
        $aResult = User::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            User::columns(),
            User::orders(),
            User::ranges()
        )->toArray();

        $aGroupID = array_unique(array_column(array_get($aResult, 'data', []), 'iCurrentGroupID'));
        $aGroupInfo = CommonUserGroupModules::getGroupName($aGroupID);
        $aResult['data'] = array_map(function($aVal) use ($aGroupInfo) {
            $aVal['sCurrentGroupName'] = isset($aGroupInfo[$aVal['iCurrentGroupID']]) ? $aGroupInfo[$aVal['iCurrentGroupID']]['sName'] : '';
            return $aVal;
        }, $aResult['data']);

        return Response::mobi($aResult);
    }

    /**
     * 新增页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $oRequest)
    {
        return view('admin.perm.user-add', [
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
            'sName' => 'required|string|min:1',
            'sMobile' => 'required|string|unique:user,sMobile',
            'sEmail' => 'required|string',
            'iGroupID' => 'integer|min:0',
        ]);
        if(! is_null( $oUserGroup = CommonUserGroup::find($aFieldValue['iGroupID']))) {
            $aFieldValue['sGroupName'] = $oUserGroup->sName;
        }
        // 设置初始密码
        $aFieldValue['sPassword'] = bcrypt('123456');

        if(! ($oUser = User::create($aFieldValue))) {
            return Response::exceptionMobi(new MobiException('CREATE_ERROR'));
        }

        return Response::mobi([]);
    }
}