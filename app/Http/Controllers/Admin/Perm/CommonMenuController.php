<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\RootController as Controller;
use App\Models\Perm\CommonMenu;
use App\Modules\Perm\CommonBusinessTypeModules;
use App\Modules\Perm\CommonUserGroupModules;
use Illuminate\Http\Request;
use App\Modules\Perm\CommonMenuModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class CommonMenuController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        return view('admin.perm.menu-list');
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
        $aResult = CommonMenu::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            CommonMenu::columns(),
            CommonMenu::orders(),
            CommonMenu::ranges()
        )->toArray();
        $aMenuType = CommonMenuModules::getMenuType();
        $aBusinessType = CommonBusinessTypeModules::getBusinessType();

        $aResult['data'] = array_map(function($aVal) use ($aMenuType, $aBusinessType) {
            $aVal['sType'] = isset($aMenuType[$aVal['iType']]) ? $aMenuType[$aVal['iType']] : '';
            $aVal['sBusinessType'] = isset($aBusinessType[$aVal['iBusinessType']]) ? $aBusinessType[$aVal['iBusinessType']]['sName'] : '';
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

        $oCommonMenu = CommonMenu::find($aFieldValue['iAutoID']);

        return view('admin.perm.menu-edit', [
            'data' => [
                'menu' => $oCommonMenu->toArray(),
                'menu_type' => CommonMenuModules::getMenuType(),
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
            'sName' => 'required|string|min:1',
            'iType' => 'integer',
            'iBusinessType' => 'integer',
            'iParentID' => 'integer',
            'sWebPath' => 'string',
            'sParam' => 'string',
            'iJumpType' => 'integer',
            'sRealUrl' => 'string',
            'iLeaf' => 'integer',
            'iShow' => 'integer',
            'iDisplay' => 'integer',
            'sIcon' => 'string',
            'iOrder' => 'integer',
            'iHome' => 'integer',
        ]);

        if(is_null($oMenu = CommonMenu::find($aFieldValue['iAutoID']))) {
            return Response::exceptionMobi(new MobiException('MENU_NOT_EXIST'));
        }

        if($aFieldValue['iParentID']) {
            if(is_null( $oParentMenu = CommonMenu::find($aFieldValue['iParentID']))) {
                return Response::exceptionMobi(new MobiException('PARENT_MENU_NOT_EXIST'));
            }
            $aFieldValue['iLevel'] = $oParentMenu->iLevel + 1;
            $aFieldValue['sRelation'] = sprintf('%s%s,', $oParentMenu->sRelation, $aFieldValue['iAutoID']);
        } else {
            $aFieldValue['iLevel'] = 1;
            $aFieldValue['sRelation'] = sprintf(',%s,', $oMenu->iAutoID);
        }

        if(! $oMenu->update($aFieldValue)) {
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
        return view('admin.perm.menu-add', [
            'data' => [
                'menu_type' => CommonMenuModules::getMenuType(),
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
            'sName' => 'required|string|min:1',
            'iType' => 'integer',
            'iBusinessType' => 'integer',
            'iParentID' => 'integer',
            'sWebPath' => 'string',
            'sParam' => 'string',
            'iJumpType' => 'integer',
            'sRealUrl' => 'string',
            'iLeaf' => 'integer',
            'iShow' => 'integer',
            'iDisplay' => 'integer',
            'sIcon' => 'string',
            'iOrder' => 'integer',
            'iHome' => 'integer',
        ]);

        if(! is_null( $oMenu = CommonMenu::find($aFieldValue['iParentID']))) {
            $aFieldValue['iLevel'] = $oMenu->iLevel + 1;
            if(! ($oNewGroup = CommonMenu::create($aFieldValue))) {
                return Response::exceptionMobi(new MobiException('CREATE_ERROR'));
            }
            $oNewGroup->sRelation = sprintf('%s%s,', $oMenu->sRelation, $oNewGroup->iAutoID);
            if(! $oNewGroup->save()) {
                return Response::exceptionMobi(new MobiException('UPDATE_ERROR'));
            }
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
        if(! CommonMenu::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }

    public function getMenuTree(Request $oRequest)
    {
        $aFieldValue = $this->validate($oRequest, [
            'iType' => 'required|integer|min:1',
            'iBusinessType' => 'required|integer|min:1',
            'iParentID' => 'integer|min:1',
        ]);
        return Response::mobi(
            CommonMenuModules::getMenuTree(
                $aFieldValue['iType'],
                $aFieldValue['iBusinessType'],
                array_get($aFieldValue, 'iParentID', 0)
            )
        );
    }

}