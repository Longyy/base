<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 22:28
 */

namespace App\Models\Perm;

use App\Models\BaseModel;

class UsersGroup extends BaseModel
{
    protected $fillable   = ['iUserID', 'iGroupType', 'iGroupID', 'sGroupName', 'iExpireTime', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID', 'iUserID', 'iGroupType', 'iGroupID', 'sGroupName', 'iExpireTime', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'users_group';

    const GROUP_TYPE_TEMP = 1; // 临时用户组
    const GROUP_TYPE_EXT = 2; // 扩展用户组
}