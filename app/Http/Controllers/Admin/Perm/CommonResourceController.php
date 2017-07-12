<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\RootController as Controller;
use App\Models\Perm\CommonResource;
use Illuminate\Http\Request;
use App\Modules\Perm\CommonResourceModules;
use Estate\Exceptions\MobiException;
use Response;
use Log;

class CommonResourceController extends Controller
{
    /**
     * 列表页
     * @param Request $oRequest
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $oRequest)
    {
        return view('admin.perm.resource-list');
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
        $aResult = CommonResource::findAll(
            array_except($aFieldValue, ['page_size']),
            array_get($aFieldValue, 'page_size', 10),
            CommonResource::columns(),
            CommonResource::orders(),
            CommonResource::ranges()
        )->toArray();
        $aResourceType = CommonResourceModules::getResourceType();
        $aResourceBusinessType = CommonResourceModules::getResourceBusinessType();
        $aResult['data'] = array_map(function($aVal) use ($aResourceType, $aResourceBusinessType) {
            $aVal['sType'] = isset($aResourceType[$aVal['iType']]) ? $aResourceType[$aVal['iType']] : '';
            $aVal['sBusinessType'] = isset($aResourceBusinessType[$aVal['iBusinessType']]) ? $aResourceBusinessType[$aVal['iBusinessType']] : '';
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

        $oCommonResource = CommonResource::find($aFieldValue['iAutoID']);
        $aResourceType = CommonResourceModules::getResourceType();
        $aResourceBusinessType = CommonResourceModules::getResourceBusinessType();

        return view('admin.perm.resource-edit', [
            'data' => [
                'resource' => $oCommonResource->toArray(),
                'resource_type' => $aResourceType,
                'resource_business_type' => $aResourceBusinessType,
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
            'iBusinessType' => 'integer',
            'sControllerName' => 'string',
            'sFunctionName' => 'string',
            'sPath' => 'string',
            'iShow' => 'integer',
        ]);

        $oCommonResource = CommonResource::find($aFieldValue['iAutoID']);
        if(! $oCommonResource->update($aFieldValue)) {
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
        $aResourceType = CommonResourceModules::getResourceType();
        $aResourceBusinessType = CommonResourceModules::getResourceBusinessType();
        return view('admin.perm.resource-add', [
            'data' => [
                'resource_type' => $aResourceType,
                'resource_business_type' => $aResourceBusinessType,
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
            'sName' => 'required|string|min:1|unique:common_resource,sName',
            'iType' => 'required|integer',
            'iBusinessType' => 'integer',
            'sControllerName' => 'string',
            'sFunctionName' => 'string',
            'sPath' => 'string',
            'iShow' => 'integer',
        ]);
        if(! CommonResource::create($aFieldValue)) {
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
        if(! CommonResource::whereIn('iAutoID', explode(',', $aFieldValue['sAutoID']))->delete()) {
            return Response::exceptionMobi(new MobiException('DELETE_ERROR'));
        }
        return Response::mobi([]);
    }

}