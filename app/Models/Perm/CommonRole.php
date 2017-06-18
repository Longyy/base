<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 21:52
 */
namespace App\Models\Perm;

use Estate\Database\Eloquent\Model;
use Estate\Exceptions\ServiceException;


class CommonRole extends Model
{
    protected $fillable   = [ 'iParentID', 'iLevel', 'sRelation', 'sName', 'iType', 'iCreateTime', 'iUpdateTime',
        'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID', 'iParentID', 'iLevel', 'sRelation', 'sName', 'iType', 'iCreateTime', 'iUpdateTime',
        'iDeleteTime', 'iStatus'];

    protected $table = 'common_role';

    // 角色类型
    const ROLE_TYPE_COMMON = 1;
    const ROLE_TYPE_LINE1 = 2;

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