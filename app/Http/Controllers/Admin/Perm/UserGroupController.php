<?php
namespace App\Http\Controllers\Admin\Perm;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 22:17
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perm\CommonUserGroup;
use Response;

class UserGroupController extends Controller
{
    public function index(Request $oRequest)
    {
        return view('admin.perm.user-group-list');
    }

    public function getList(Request $oRequest)
    {
        $data = CommonUserGroup::all()->toArray();
//        $str = <<<EOD
//{
//  "list": [
//    {
//      "iAutoID": 1,
//      "sName": "bootstrap-table",
//      "iType": 2156,
//      "iCreateTime": 633,
//      "iUpdateTime": "An extended Bootstrap table with radio, checkbox, sort, pagination, and other added features."
//    }
//  ]
//}
//EOD;

//        return Response::json(json_decode($str, true));
        return Response::json(['total' => 6, 'rows' => $data]);
    }
}