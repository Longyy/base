<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13
 * Time: 19:23
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\RootController as Controller;
use App\Models\User;
use App\Modules\Perm\CommonUserGroupModules;
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
}