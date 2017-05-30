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


class CommonRoleUserGroupRelation extends Model
{
    protected $fillable   = [ 'iRoleID', 'iGroupID',  'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = ['iAutoID', 'iRoleID', 'iGroupID',  'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'common_role_usergroup_relation';

    public static function getRoleIDByGroupIDs($aGroupID)
    {
       return static::whereIn('iGroupID', $aGroupID)->lists('iRoleID');
    }
}