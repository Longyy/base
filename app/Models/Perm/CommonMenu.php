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


class CommonMenu extends Model
{
    protected $fillable   = [ 'sName', 'iType', 'iBusinessType', 'iCommon', 'iParentID', 'iLevel', 'sRelation',
        'sAndroidPath', 'sIosPath', 'sH5Path', 'sWebPath', 'sParam', 'iJumpType', 'sRealUrl', 'iLeaf', 'iShow',
        'sIcon', 'iOrder', 'iHome', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = [ 'iAutoID', 'sName', 'iType', 'iBusinessType', 'iCommon', 'iParentID', 'iLevel', 'sRelation',
        'sAndroidPath', 'sIosPath', 'sH5Path', 'sWebPath', 'sParam', 'iJumpType', 'sRealUrl', 'iLeaf', 'iShow',
        'sIcon', 'iOrder', 'iHome', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'common_menu';

    /**
     * @param array $aWhere   option  条件值
     * @param int   $iPerPage option  分页大小
     * @param array $aColumns option  字段选择
     * @param array $aOrders  option  字段排序
     * @param array $aRanges  option  字段范围查询
     * @return mixed
     */
    public static function findAll(array $aWhere = [], $iPerPage = 10, array $aColumns = [], $aOrders = [], array $aRanges = [])
    {
        $oMenu = new static;
        foreach($aWhere as $sKey => $mValue) {
            if(is_array($mValue)) {
                $oMenu = $oMenu->whereIn($sKey, $mValue);
            } else {
                $oMenu = $oMenu->where($sKey, $mValue);
            }
        }
        return $oMenu->withOrder($aOrders)->withRange($aRanges)->paginate($iPerPage, $aColumns);
    }
}