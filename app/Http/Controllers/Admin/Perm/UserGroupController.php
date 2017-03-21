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

class UserGroupController extends Controller
{
    public function index(Request $oRequest)
    {
        return view('admin.perm.user-group-list');
    }
}