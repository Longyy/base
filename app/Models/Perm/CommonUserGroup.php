<?php
namespace App\Models\Perm;

use Estate\Database\Eloquent\Model;
use Estate\Exceptions\ServiceException;

class CommonUserGroup extends Model
{
//    protected $connection = 'zt_db';
    protected $fillable   = ['iParentID', 'iLevel', 'sRelation', 'sName', 'iType', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID','iParentID', 'iLevel', 'sRelation',  'sName', 'iType', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'common_usergroup';

    /**
     * 查询
     * @param array $aWhere
     * @param int $iPerPage
     * @param array $aColumns
     * @param array $aOrder
     * @param array $aRanges
     * @return mixed
     */
    public static function findAll(array $aWhere = [], $iPerPage = 10, array $aColumns = ['*'], array $aOrder = ['*'], array $aRanges = [])
    {
        $oUserGroup = new Static;
        foreach($aWhere as $sKey => $mValue) {
            $oUserGroup = $oUserGroup->where($sKey, $mValue);
        }
        return $oUserGroup->withOrder($aOrder)->withRange($aRanges)->paginate($iPerPage, $aColumns);
    }


}