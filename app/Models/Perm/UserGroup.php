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
    protected $fillable   = ['iUserID', 'iGroupType', 'iGroupID', 'iPrepend', 'sGroupName', 'iExpireTime', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID', 'iUserID', 'iGroupType', 'iGroupID', 'iPrepend', 'sGroupName', 'iExpireTime', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'user_group';

    const GROUP_TYPE_TEMP = 1; // 临时用户组
    const GROUP_TYPE_EXT = 2; // 扩展用户组

    const PREPEND_YES = 2; // 用户组合并
    const PREPEND_NO = 1; // 用户组不合并

    public static function getUserGroup($iUserID)
    {
        return static::where('iUserID', $iUserID)->where('iExpireTime', '>', time())->get();

    }

    /**
     * 查询
     * @param array $aWhere
     * @param int $iPerPage
     * @param array $aColumns
     * @param array $aOrder
     * @param array $aRanges
     * @return mixed
     */
    public static function findAll(array $aWhere = [], $iPerPage = 10, array $aColumns = ['*'], array $aOrders = [], array $aRanges = [])
    {
        $oUserGroup = new Static;
        foreach($aWhere as $sKey => $mValue) {
            $oUserGroup = $oUserGroup->where($sKey, $mValue);
        }
        return $oUserGroup->withOrder($aOrders)->withRange($aRanges)->paginate($iPerPage, $aColumns);
    }
}