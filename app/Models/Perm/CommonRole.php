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
}