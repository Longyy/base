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
use App\Models\Perm\CommonMenu;
use App\Models\Perm\CommonRole;
use App\Models\Perm\CommonRoleMenu;
use App\Modules\Perm\CommonBusinessTypeModules;
use App\Modules\Perm\CommonRoleModules;
use Illuminate\Http\Request;
use App\Modules\Perm\CommonRoleMenuModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class CommonRoleMenuController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        return view('admin.perm.role-menu-list', [
            'data' => [
                'role_type' => CommonRoleModules::getRoleType(),
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
            'iRoleID' => 'integer|min:0',
        ]);
        $aResult = CommonRoleMenu::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            CommonRoleMenu::columns(),
            CommonRoleMenu::orders(),
            CommonRoleMenu::ranges()
        )->toArray();
        $aRoleID = array_unique(array_column($aResult['data'], 'iRoleID'));
        $aMenuID = array_unique(array_column($aResult['data'], 'iMenuID'));
        $aRole = CommonRole::whereIn('iAutoID', $aRoleID)->select('iAutoID', 'sName')->get()->toArray();
        $aMenu = CommonMenu::whereIn('iAutoID', $aMenuID)->select('iAutoID', 'sName')->get()->toArray();
        $aRole = Tools::useFieldAsKey($aRole, 'iAutoID');
        $aMenu = Tools::useFieldAsKey($aMenu, 'iAutoID');
        $aResult['data'] = array_map(function($aVal) use ($aRole, $aMenu) {
            $aVal['sRoleName'] = isset($aRole[$aVal['iRoleID']]) ? $aRole[$aVal['iRoleID']]['sName'] : '';
            $aVal['sMenuName'] = isset($aMenu[$aVal['iMenuID']]) ? $aMenu[$aVal['iMenuID']]['sName'] : '';
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

        $oCommonRoleMenu = CommonRoleMenu::find($aFieldValue['iAutoID']);
        $oCommonRole = CommonRole::find($oCommonRoleMenu->iRoleID);
        $oCommonMenu = CommonMenu::find($oCommonRoleMenu->iMenuID);

        return view('admin.perm.role-menu-edit', [
            'data' => [
                'role' => $oCommonRole->toArray(),
                'menu' => $oCommonMenu->toArray(),
                'role_menu' => $oCommonRoleMenu->toArray(),
                'business_type' => CommonBusinessTypeModules::getBusinessType(),
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
            'iRoleID' => 'required|integer',
            'iMenuID' => 'required|integer',
        ]);

        if(is_null($oCommonRoleMenu = CommonRoleMenu::find($aFieldValue['iAutoID']))) {
            return Response::exceptionMobi(new MobiException('RECORD_NOT_EXIST'));
        }

        $aCommonRoleMenu = $oCommonRoleMenu->toArray();
        if($aFieldValue == array_only($aCommonRoleMenu, ['iAutoID', 'iRoleID', 'iMenuID'])) {
            return Response::exceptionMobi(new MobiException('NOTHING_CHANGED'));
        }

        if(1 < CommonRoleMenu::where(array_except($aFieldValue, ['iAutoID']))->count()) {
            return Response::exceptionMobi(new MobiException('REPLICATED_RECORD'));
        }

        if(! $oCommonRoleMenu->update($aFieldValue)) {
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
        return view('admin.perm.role-menu-add', [
            'data' => [
                'role_type' => CommonRoleModules::getRoleType(),
                'business_type' => CommonBusinessTypeModules::getBusinessType(),
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
            'iRoleID' => 'required|integer',
            'iMenuID' => 'required|integer',
        ]);
        if(CommonRoleMenu::where($aFieldValue)->count()) {
            return Response::exceptionMobi(new MobiException('RELATION_HAS_EXISTED'));
        }
        if(! CommonRoleMenu::create($aFieldValue)) {
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
        if(! CommonRoleMenu::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }

}