<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\RootController as Controller;
use App\Models\Perm\CommonRolePerm;
use Illuminate\Http\Request;
use App\Modules\Perm\CommonRolePermModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class CommonRolePermController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        return view('admin.perm.role-perm-list');
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
        ]);
        $aResult = CommonRolePerm::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            CommonRolePerm::columns(),
            CommonRolePerm::orders(),
            CommonRolePerm::ranges()
        )->toArray();
//        $aGroupType = CommonRolePermModules::getGroupType();
//        $aResult['data'] = array_map(function($aVal) use ($aGroupType) {
//            $aVal['sType'] = isset($aGroupType[$aVal['iType']]) ? $aGroupType[$aVal['iType']] : '';
//            return $aVal;
//        }, $aResult['data']);

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

        $oCommonRolePerm = CommonRolePerm::find($aFieldValue['iAutoID']);
        $aGroupType = CommonRolePermModules::getGroupType();

        return view('admin.perm.user-group-edit', [
            'data' => [
                'user_group' => $oCommonRolePerm->toArray(),
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

        $oCommonRolePerm = CommonRolePerm::find($aFieldValue['iAutoID']);
        Log::info('update ', [$aFieldValue]);
        if(! $oCommonRolePerm->update($aFieldValue)) {
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
                'group_type' => CommonRolePermModules::getGroupType(),
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
            'sName' => 'required|string|min:1|unique:common_CommonRolePerm,sName',
            'iType' => 'integer',
        ]);
        if(! CommonRolePerm::create($aFieldValue)) {
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
        if(! CommonRolePerm::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }

}