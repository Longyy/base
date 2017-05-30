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


class CommonRoleMenu extends Model
{
    protected $fillable   = [ 'iRoleID', 'iMenuID', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];
    protected $orderable  = ['*'];
    protected $rangeable  = ['*'];
    protected $columnable = [ 'iAutoID', 'iRoleID', 'iMenuID', 'iCreateTime', 'iUpdateTime', 'iDeleteTime', 'iStatus'];

    protected $table = 'common_role_menu';

    public static function getMenuIDByRoleIDs($aRoleID)
    {
        return static::whereIn('iRoleID', $aRoleID)->lists('iMenuID');
    }
}