<?php

namespace App\Models;

use Estate\Database\Eloquent\Model;
use Estate\Exceptions\ServiceException;

class User extends Model
{
    protected $table = 'user';

    protected $fillable = ['sName', 'sEmail', 'sMobile', 'sPassword', 'sRememberToken', 'iGroupID', 'sGroupName', 'iCurrentGroupID', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $hidden = ['sPassword', 'sRememberToken'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID', 'sName', 'sEmail', 'sMobile', 'sPassword', 'sRememberToken', 'iGroupID', 'sGroupName', 'iCurrentGroupID', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

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
        $oUser = new static;
        foreach($aWhere as $sKey => $mValue) {
            $oUser = $oUser->where($sKey, $mValue);
        }
        return $oUser->withOrder($aOrders)->withRange($aRanges)->paginate($iPerPage, $aColumns);
    }

    /**
     * 更新
     * @param $iAutoID
     * @param array $aData
     * @return mixed
     * @throws ServiceException
     */
    public static function updateByID($iAutoID, array $aData)
    {
        if($oUser = self::find($iAutoID)) {
            throw new ServiceException('ROW_NOT_FOUND');
        }
        return $oUser->update($aData);
    }

    public static function getUserByName($sName)
    {
        $oUser = new static;
        return $oUser->where(['sName' => $sName])->first();
    }

    public static function getUserByToken($sToken)
    {
        $oUer = new static;
        return $oUer->where(['sRememberToken' => $sToken])->first();
    }
}
