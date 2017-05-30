<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 22:28
 */

namespace App\Models\Perm;

use Estate\Database\Eloquent\Model;
use Estate\Exceptions\ServiceException;

class UserGroup extends Model
{
    protected $fillable   = ['iUserID', 'iGroupType', 'iGroupID', 'sGroupName', 'iExpireTime', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID', 'iUserID', 'iGroupType', 'iGroupID', 'sGroupName', 'iExpireTime', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'user_group';

    const GROUP_TYPE_TEMP = 1; // 临时用户组
    const GROUP_TYPE_EXT = 2; // 扩展用户组

    public static function getUserGroup($iUserID)
    {
        $oGroup = new static;
        return $oGroup->where('iUserID', $iUserID)->where('iExpireTime', '<', time())->get();

    }
}